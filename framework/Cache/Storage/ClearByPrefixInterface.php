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
 * Интерфейс удаления элементов соответствующие заданному префиксу.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage
 * @since 2.0
 */
interface ClearByPrefixInterface
{
    /**
     * Удаление элементов, соответствующие заданному префиксу.
     *
     * @param string $prefix Имя префикса.
     * 
     * @return bool true - если удаление было успешно.
     */
    public function clearByPrefix($prefix);
}
