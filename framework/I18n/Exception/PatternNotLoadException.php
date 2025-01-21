<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\I18n\Exception;

use Throwable;
use Gm\Exception\NotDefinedException;

/**
 * Исключение возникающие при загрузке вызываемого шаблона локализации.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\I18n\Exception
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
     * {@inheritdoc}
     * 
     * @param string $filename Имя файла шаблона.
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
        return sprintf('Can not include language file "%s"', $this->filename ?: 'unknow');
    }
}
