<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\User;

/**
 * UserDataInterface - это интерфейс, который должен быть реализован классом, 
 * предоставляющий данные аутентификации пользователя.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\User
 * @since 2.0
 */
interface UserDataInterface
{
    /**
     * Поиска данных аутентификации пользователя.
     * 
     * Выполнение запроса к базе данных используя Active Record {@see \Gm\Db\ActiveRecord}.
     * 
     * @return array|\Gm\Db\ActiveRecord|null
     */
    public function find();

    /**
     * Читает данные аутентификации пользователя из хранилища.
     * 
     * Метод используется только для хранилища аутентификации пользователя.
     * 
     * @return null|array Если null, данные аутентификации пользователя отсутствуют в 
     *     хранилище.
     */
    public function read();

    /**
     * Записывает данные аутентификации пользователя в хранилище.
     * 
     * Метод используется только для хранилища аутентификации пользователя.
     * 
     * @return void
     */
    public function write();
}
