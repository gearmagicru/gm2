<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Cache\Storage;

/**
 * Интерфейс общего пространство в байтах.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage
 * @since 2.0
 */
interface TotalSpaceCapableInterface
{
    /**
     * Получение общего пространство в байтах.
     *
     * @return int|float Пространство в байтах.
     */
    public function getTotalSpace();
}
