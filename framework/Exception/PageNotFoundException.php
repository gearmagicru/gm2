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
 * Исключение представлено в виде ошибки HTTP («не найдено») с кодом состояния 404.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class PageNotFoundException extends NotFoundException
{
    /**
     * {@inheritdoc}
     */
    public string $viewFile = '//errors/404';

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
        parent::__construct(404, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('404 Not Found.');
    }
}
