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
 * Интерфейс удаления истекших по времени элементов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage
 * @since 2.0
 */
interface ClearExpiredInterface
{
    /**
     * Удаление истекших по времени элементов.
     *
     * @return bool true - если удаление было успешно.
     */
    public function clearExpired();
}
