<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Filesystem\Exception;

use Gm\Exception\UserException;

/**
 * Исключение возникающие во время выполнения действия.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filesystem\Exception
 * @since 2.0
 */
class RuntimeException extends UserException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return 'Runtime exception';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Runtime exception';
    }
}
