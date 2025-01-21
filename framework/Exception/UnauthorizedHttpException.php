<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

use Throwable;

/**
 * Исключение представлено в виде ошибки HTTP («неавторизованного доступа») с кодом состояния 401.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class UnauthorizedHttpException extends HttpException
{
    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки.
     * @param int $code Код ошибки.
     * @param \Exception $previous Предыдущие исключение.
     * 
     * @return void
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(401, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Access error. To perform an action, you must pass authorization.');
    }
}
