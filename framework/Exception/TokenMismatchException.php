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
 * Исключение при проверки токенов, представлено в виде ошибки HTTP («отказ в доступе») 
 * с кодом состояния 401.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class TokenMismatchException extends HttpException
{
    /**
     * {@inheritdoc}
     */
    public string $viewFile = '//errors/401';

    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки  (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(401, $message, $code, $previous);
    }
}
