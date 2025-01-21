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
use Gm\Stdlib\Component;
use Gm\Mvc\Controller\Controller;
use Gm\Exception\TokenMismatchException;

/**
 * CsrfFilter - выполняет проверку CSRF  (подделка межсайтовых запросов) для разрешенных 
 * действий контроллеров.
 * 
 * Он включает проверку CSRF для разрешенных действий контроллеров и выдаёт ошибку HTTP 401, 
 * если запрос проверку не прошел.
 * 
 * Чтобы использовать CsrfFilter, его необходимо объявить в `behavior()` класса 
 * контроллера или модуля. Например, следующие объявления будут определять типичный 
 * набор действий REST CRUD контроллера для которых выполняется проверка CSRF.
 * Для контроллера:
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'csrf' => [
 *             'class'   => '\Gm\Filter\CsrfFilter',
 *             'actions' => [
 *                 '*'    => true
 *                 ''     => false,
 *                 'view' => [
 *                     'enableCsrfCookie'  => true,
 *                     'enableCsrfSession' => false
 *                 ]
 *             ]
 *         ]
 *     ];
 * }
 * ```
 * где параметр конфигурации `actions` фильтра может иметь значения:
 * - `*`, имена действий, которые не указаны в массиве;
 * - `''`, имя действия по умолчанию, определяется свойством контроллера {@see \Gm\Mvc\Controller\BaseController::$defaultAction}.

 * Для модуля:
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'csrf' => [
 *             'class'       => '\Gm\Filter\CsrfFilter',
 *             'controllers' => [
  *                 '*' => [
 *                     // действия контроллера
 *                 ],
   *               '' => [
 *                     // действия контроллера
 *                 ],
 *                 'Controller' => [
 *                     '*'    => true
 *                     ''     => false,
 *                     'view' => [
 *                         'enableCsrfCookie'  => true,
 *                         'enableCsrfSession' => false
 *                      ]
 *                 ],
 *             ]
 *         ]
 *     ];
 * }
 * ```
 * где параметр конфигурации `controllers` может иметь значения:
 * - `*`, имена контроллеров, которые не указаны в массиве;
 * - `''`, имя контроллера по умолчанию, определяется свойством модуля {@see \Gm\Mvc\Module\BaseModule::$defaultController}.
 * Параметры проверки CSRF могуть быть представлены в виде массива пар "property => value". 
 * Где `property` - это свойство класса HTTP-запроса {@see \Gm\Http\Request\Request}. Здесь
 * указывают такие свойства:
 * - `enableCsrfCookie`, использовать cookie для хранения токена CSRF {@see \Gm\Http\Request\Request::$enableCsrfCookie};
 * - `enableCsrfSession`, использовать сессию для хранения токена CSRF {@see \Gm\Http\Request\Request::$enableCsrfSession}.
 * Значение `property` может иметь `true` (будет проверка) или `false` (не будет проверки).
 * 
 * Если CsrfFilter используется для контроллера, то контроллер должен иметь `enableCsrfValidation = false`. Иначе, проверки 
 * не будет, т.к. сам контроллер делает ёё своим методом {@see \Gm\Mvc\Controller\Controller::verifyCsrf()}.
 * 
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filter
 * @since 2.0
 */
class CsrfFilter extends RunFilter
{
    /**
     * {@inheritdoc}
     */
    public function attach(Component $owner): void
    {
        if ($owner instanceof Controller) {
            if ($owner->enableCsrfValidation) {
                return;
            }
        }

        parent::attach($owner);
    }

    /**
     * Фильтрация действия.
     * 
     * @param bool|array Параметры проверки CSRF:
     *     - если массив пар "property => value",  где `property` - это свойство класса 
     *     HTTP-запроса {@see \Gm\Http\Request\Request}.
     *     - если `true`, выполнять проверку;
     *     - если `false`, не выполнять проверку.
     * 
     * @return bool Если значение `true`, запрос успешно прошел проверку.
     * 
     * @throws TokenMismatchException Несоответствие токена CSRF.
     */
    public function filtering(mixed $params): bool
    {
        /** @var \Gm\Http\Request $request */
        $request = Gm::$app->request;

        if (is_array($params)) {
            foreach ($params as $property => $value) {
                $request->{$property} = $value;
            }
        } elseif ($params === false) {
            return true;
        }
        // если !$request->enableCsrfValidation или $request->isSafeMethod() всегда будет true
        $validate = $request->validateCsrfToken();
        if (!$validate) {
            // если пользователь ранее авторизован
            Gm::$app->session->destroy();
            throw new TokenMismatchException(Gm::t('app', 'CSRF token mismatch'));
        }
        return true;
    }
}
