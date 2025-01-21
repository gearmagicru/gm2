<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\User;

use Gm\Session\Storage\SessionStorage;

/**
 * Хранилище аутентификации пользователя.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\User
 * @since 2.0
 */
class UserSessionStorage extends SessionStorage
{
    /**
     * {@inheritdoc}
     */
    protected string $name = 'Gm_User';
}
