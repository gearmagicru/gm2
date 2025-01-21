<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Log;

use Gm\ServiceManager\AbstractManager;

/**
 * Класс менеджера служб Логгера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Log
 * @since 2.0
 */
class LoggerManager extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    protected array $invokableClasses = [
        'xml'     => 'Gm\Log\Writer\XmlWriter',
        'file'    => 'Gm\Log\Writer\FileWriter',
        'message' => 'Gm\Log\Writer\MessageWriter',
        'error'   => 'Gm\Log\Writer\ErrorWriter',
        'debug'   => 'Gm\Log\Writer\DebugWriter',
    ];
}
