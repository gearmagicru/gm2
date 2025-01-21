<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\ModuleManager\Exception;

use Gm\Exception\UserException;

/**
 * Исключение возникающие при удалении модуля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\ModuleManager\Exception
 * @since 2.0
 */
class UninstallException extends UserException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return 'Uninstalling module.';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Uninstalling module';
    }
}
