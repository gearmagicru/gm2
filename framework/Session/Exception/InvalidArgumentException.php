<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Session\Exception;

use Gm\Exception;

/**
 * {@inheritdoc}
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Session\Exception
 * @since 2.0
 */
class InvalidArgumentException extends Exception\InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return 'Invalid session argument.';
    }
}
