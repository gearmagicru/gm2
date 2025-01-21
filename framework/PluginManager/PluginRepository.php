<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\PluginManager;

use Gm\ModuleManager\BaseRepository;

/**
 * Класс репозитория плагинов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\PluginManager
 * @since 2.0
 */
class PluginRepository extends BaseRepository
{
    /**
     * Конструктор класса.
     * 
     * @param null|PluginManager $manager Менеджер плагинов.
     * 
     * @return void
     */
    public function __construct(?PluginManager $manager = null)
    {
        $this->manager = $manager;
    }
}
