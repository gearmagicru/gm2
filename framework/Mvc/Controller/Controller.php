<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Controller;

use Gm;

/**
 * Контроллер является базовым классом для классов, содержащих логику контроллера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Controller
 * @since 2.0
 */
class Controller extends BaseController
{
    /**
     * Включает проверку CSRF (подделка межсайтовых запросов).
     * 
     * Свойство отключает или включает {@see \Gm\Http\Request::$enableCsrfValidation}.
     * 
     * Если необходимо выполнить проверку для конкретного действия, используйте
     * поведение {@see \Gm\Filter\CsrfFilter}, тогда значение должно быть `false`.
     * 
     * @see Controller::verifyCsrf()
     * @see \Gm\Http\Request::$enableCsrfValidation
     * 
     * @var bool
     */
    public bool $enableCsrfValidation = true;

    /**
     * Проверка CSRF (подделка межсайтовых запросов).
     * 
     * @return void
     */
    protected function verifyCsrf(): void
    {
        if ($this->enableCsrfValidation) {
            /** @var \Gm\Http\Request $request */
            $request = Gm::$app->request;
            // запрос и контроллер позволяют делать проверку CSRF
            if ($request->enableCsrfValidation) {
                // если !$request->enableCsrfValidation или $request->isSafeMethod() всегда будет true
                $validate = $request->validateCsrfToken();
                if (!$validate) {
                    // если пользователь ранее авторизован
                    Gm::$app->session->destroy();
                    throw new Exception\TokenMismatchException(Gm::t('app', 'CSRF token mismatch'));
                }
            }
        }
    }

    /**
     * @see \Gm\Mvc\Module\ModulePermission::checkAccess()
     * 
     * {@inheritdoc}
     */
    protected function accessAction(string $action): bool
    {
        return $this->module->getPermission()->checkAccess($action);
    }

    /**
     * {@inheritdoc}
     */
    public function onAccess(): bool
    {
        if (parent::onAccess()) {
            // проверить CSRF 
            $this->verifyCsrf();
            return true;
        }
        return false;
    }
}
