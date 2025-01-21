<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Log\Writer;

/**
 * Класс писателя сообщений в файл журнала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Log\Writer
 * @since 2.0
 */
class MessageWriter extends FileWriter
{
    /**
     * {@inheritdoc}
     */
    public string $formatMessage = '[%timestamp%]: %message%';
}
