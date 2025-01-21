<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Permissions\Rbac;

/**
 * Интерфейс утверждения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Permissions\Rbac
 * @since 2.0
 */
interface AssertionInterface
{
    /**
     * Метод утверждения - должен возвращать логическое значение.
     *
     * @param Rbac $rbac
     * 
     * @return bool
     */
    public function assert(Rbac $rbac): bool;
}
