<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

/**
 * Исключение возникающие при вызове класса.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class InvalidClassException extends UserException
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Invalid Class';
    }
}
