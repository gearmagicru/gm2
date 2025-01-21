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
 * Интерфейс удаления элементов заданного пространства имён.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage
 * @since 2.0
 */
interface ClearByNamespaceInterface
{
    /**
     * Удаление элементов заданного пространства имён.
     *
     * @param string $namespace Пространство имён.
     * 
     * @return bool true - если удаление было успешно.
     */
    public function clearByNamespace($namespace);
}
