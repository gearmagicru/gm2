<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator\Exception;

use Throwable;
use Gm\Exception\NotDefinedException;

/**
 * Исключение возникающие при загрузке файла шаблона.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator\Exception
 * @since 2.0
 */
class PatternNotLoadException extends NotDefinedException
{
    /**
     * Имя файла шаблона.
     * 
     * @var string
     */
    public string $filename = '';

    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки  (по умолчанию '').
     * @param string $filename Имя файла шаблона.
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $message = '', string $filename = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->filename = $filename;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Can not include pattern file "%s"', $this->filename ?: 'unknow');
    }
}
