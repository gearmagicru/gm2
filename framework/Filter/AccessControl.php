<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Filter;

use Gm;
use Closure;
use Gm\User\User;
use Gm\Stdlib\Behavior;
use Gm\Stdlib\Component;
use Gm\Stdlib\BaseObject;
use Gm\Mvc\Controller\BaseController;
use Gm\Mvc\Module\Exception\ForbiddenHttpException;

/**
 * AccessControl обеспечивает простой контроль доступа на основе набора правил.
 * 
 * AccessControl - это фильтр действий. Он проверит свои правила {@see AccessControl::$rules}, 
 * чтобы найти первое правило, которое соответствует текущим переменным контекста 
 * (таким как пользователь, разрешения (permission)). Правило сопоставления будет 
 * определять, разрешить или запретить доступ к запрошенному действию контроллера. 
 * Если ни одно правило не соответствует, в доступе будет отказано.
 * 
 * Чтобы использовать AccessControl, объявите его в методе `behavior()` вашего класса 
 * контроллера или модуля. Например, следующие объявления позволят аутентифицированным 
 * пользователям получить доступ к действиям: "создать", "обновить", "просмотреть" свой 
 * профиль c разрешением "read/write" и запретить всем другим пользователям доступ к этим 
 * действиям.
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => '\Gm\Filter\AccessControl',
 *             'rules' => [
 *                 // страница авторизации доступна для всех
 *                 [
 *                     'allow',
 *                     'controllers' => ['Index'],
 *                 ],
 *                 // для авторизованных пользователей 
 *                 [
 *                     'allow',
 *                     'controllers' => [
 *                         'Profile' => ['create', 'update', 'view']
 *                     ],
 *                     'permission'  => 'read/write',
 *                     'users'       => ['@frontend']
 *                 ],
 *                 //  для всех остальных, доступа нет
 *                 [
 *                      'deny',
 *                      'exception' => 404
 *                 ],
 *             ],
 *         ],
 *     ];
 * }
 * ```
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filter
 * @since 2.0
 */
class AccessControl extends Behavior
{
    /**
     * Проверяет доступ модуля к своему расширению.
     * 
     * Для доступа, необходимо, чтобы модуль имел разрешение "extension".
     * 
     * @see AccessControl::beforeAccess()
     * 
     * @var bool
     */
    public bool $checkParentAccess = false;

    /**
     * Класс проверяющий доступ на основе указанных правил.
     * 
     * @var string
     */
    public string $rulesClass = '\Gm\Filter\AccessRules';

    /**
     * Массив правил определяющих доступ пользователя к действиям 
     * контроллеров.
     * 
     * @var array
     */
    public array $rules = [];

    /**
     * Пользователь.
     * 
     * @var User
     */
    public User $user;

    /**
     * Обратный вызов, который будет вызываться, если в доступе будет отказано текущему 
     * пользователю.
     * 
     * Если не установлен или же результат вызова `true`, то будет вызван {@see AccessControl::denyAccess()}.
     * 
     * Сигнатура обратного вызова должна быть следующей:
    * ```php
     * function ($controller, $actionName)
     * ```
     * где, `$controller` - текущи объект контроллера, а `$actionName` - текущее действие.
     * 
     * @var Closure
     */
    public ?Closure $denyCallback = null;

    /**
     * Объект проверяющий доступ.
     * 
     * @see AccessControl::getAccessRules()
     * 
     * @var BaseObject|null
     */
    protected ?BaseObject $_accessRules = null;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        if (!isset($this->user)) {
            $this->user = Gm::$services->getAs('user');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attach(Component $owner): void
    {
        $this->owner = $owner;
        $owner->on($owner::EVENT_BEFORE_RUN, [$this, 'beforeAccess']);
    }

    /**
     * {@inheritdoc}
     */
    public function detach(): void
    {
        if ($this->owner) {
            $this->off($this->owner::EVENT_BEFORE_RUN, [$this, 'beforeAccess']);
            $this->owner = null;
        }
    }

    /**
     * Этот метод вызывается прямо перед перед запуском владельца (модуля или 
     * контроллера).
     * 
     * @param BaseController $controller Текущий контроллер.
     * @param string $actionName Текущее действие контроллера.
     * @param bool $isAllowed Результат определяется в этом методе и вернётся для контроллера в 
     *    {@see \Gm\Mvc\Controller\BaseController::beforeRun()}, а для модуля в 
     *    {@see \Gm\Mvc\Module\BaseModule::beforeRun()} и станет результатом выполнения
     *    их методов.
     * 
     * @return void
     */
    public function beforeAccess(BaseController $controller, string $actionName, bool &$isAllowed): void
    {
        if ($this->checkParentAccess) {
            if (!$controller->module->parent->getPermission()->canExtension()) {
                $this->denyAccess();
            }
        }
        /** @var \Gm\Filter\AccessRules $access */
        $access = $this->getAccessRules($controller->getShortClass(), $actionName);
        $isAllowed = $access->match();
        if (!$isAllowed) {
            if ($this->denyCallback instanceof Closure) {
                if ($this->denyCallback->call($this, $controller, $actionName))
                    $this->denyAccess();
            } else {
                $this->denyAccess();
            }
        }
    }

    /**
     * Возвращает объект проверяющий доступ.
     * 
     * Для повторного вызова метода необходимо указать `$controllerName = null` и 
     * `$actionName = null`.
     * 
     * @see AccessControl::$_accessRules
     * 
     * @param string|null $controllerName Имя контроллера для которого выполняется 
     *     проверка доступа. 
     * @param string|null $actionName Имя действия для которого выполняется проверка 
     *     доступа.
     * 
     * @return BaseObject
     */
    public function getAccessRules(string $controllerName = null, string $actionName = null)
    {
        if ($this->_accessRules === null) {
            if ($this->owner instanceof BaseController) {
                $module = $this->owner->getModule();
            } else {
                $module = $this->owner;
            }
            $this->_accessRules = Gm::createObject(
                $this->rulesClass, $this->rules, $module, $controllerName, $actionName
            );
        }
        return $this->_accessRules;
    }

    /**
     * Запрещает доступ пользователю.
     * 
     * По умолчанию перенаправит пользователя на страницу авторизации если он гость.
     * Если пользователь уже вошел в систему, будет выдано исключение 403 HTTP.
     * 
     * @return void
     * 
     * @throws ForbiddenHttpException Запрет на выполнения действия.
     */
    protected function denyAccess(): void
    {
        if ($this->user->isGuest()) {
            $this->user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Gm::t('app', 'You are not allowed to perform this action'));
        }
    }
}
