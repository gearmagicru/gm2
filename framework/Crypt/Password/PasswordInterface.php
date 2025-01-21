<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Crypt\Password;

/**
 * Интерфейс создания хеш пароля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Crypt\Password
 * @since 2.0
 */
interface PasswordInterface
{
    /**
     * Создаёт хеш пароля для заданного значения.
     *
     * @param string $password Пароль.
     * 
     * @return false|string Хеш пароля.
     */
    public function create(string $password): false|string;

    /**
     * Проверяет хеш пароля с заданным значением.
     *
     * @param string $password Пароль.
     * @param string $hash Проверяемый хеш.
     * 
     * @return bool
     */
    public function verify(string $password, string $hash): bool;
}
