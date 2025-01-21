<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Cache\Storage;

use Gm\ServiceManager\ServiceManager;

/**
 * Менеджер плагинов адаптера.
 * 
 * Менеджер создаёт и хранит плагины адаптера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage
 * @since 2.0
 */
class AdapterPluginManager extends ServiceManager
{
    /**
     * {@inheritdoc}
     */
    public $invokableClasses = array(
        'session'   => 'Gm\Cache\Storage\Adapter\Session',
        'memcache'  => 'Gm\Cache\Storage\Adapter\Memcache',
        'memcached' => 'Gm\Cache\Storage\Adapter\Memcached',

    );
}
