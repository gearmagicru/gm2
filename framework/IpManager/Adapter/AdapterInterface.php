<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\IpManager\Adapter;

/**
 * Интерфейс адаптера проверки IP-адресов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\IpManager\Adapter
 * @since 2.0
 */
interface AdapterInterface
{
    /**
     * Сбрасывает полученную информацию о записяз IP-адресов.
     * 
     * @return void
     */
    public function reset(): void;

    /**
     * Удаляет всю информацию о записях IP-адресов.
     * 
     * @return bool
     */
    public function clear(): bool;
}
