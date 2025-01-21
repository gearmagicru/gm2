<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Permissions\Rbac;

use RecursiveIterator;

/**
 * Интерфейс роли.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Permissions\Rbac
 * @since 2.0
 */
interface RoleInterface extends RecursiveIterator
{
    /**
     * Возвращает имя роли.
     *
     * @return string Имя роли.
     */
    public function getName(): string;

    /**
     * Добавляет разрешение для роли.
     *
     * @param $name Имя разрешения.
     * 
     * @return $this
     */
    public function addPermission(string $name): static;

    /**
     * Проверяет, существует ли разрешение для этой роли или дочерних ролей.
     *
     * @param string $name Имя разрешения.
     * 
     * @return bool
     */
    public function hasPermission(string $name): bool;

    /**
     * Добавляет дочернию роль.
     *
     * @param RoleInterface|string $child Дочерняя роль или ёё название.
     * 
     * @return $this
     */
    public function addChild(RoleInterface|string $child): static;

    /**
     * Устанавливает родительскую роль.
     * 
     * @param RoleInterface $parent Родительская роль.
     * 
     * @return $this
     */
    public function setParent(RoleInterface $parent): static;

    /**
     * Возврашает родительскую роль.
     * 
     * @return null|RoleInterface
     */
    public function getParent(): ?RoleInterface;
}
