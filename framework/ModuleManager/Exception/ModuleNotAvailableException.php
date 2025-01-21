<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\ModuleManager\Exception;

use Throwable;
use Gm\Exception\NotFoundException;

/**
 * Исключение возникающие при недоступном вызове модуля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\ModuleManager\Exception
 * @since 2.0
 */
class ModuleNotAvailableException extends NotFoundException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }
}
