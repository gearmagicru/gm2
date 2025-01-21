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
 * Роль пользователя.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Permissions\Rbac
 * @since 2.0
 */
class Role extends AbstractRole
{
    /**
     * Конструктор класса.
     * 
     * @param string $name Имя роли.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
