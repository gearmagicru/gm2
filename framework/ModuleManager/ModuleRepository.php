<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\ModuleManager;

/**
 * Класс репозитория модулей.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\ModuleManager
 * @since 2.0
 */
class ModuleRepository extends BaseRepository
{
    /**
     * Конструктор класса.
     *
     * @param null|ModuleManager $manager Менеджер модулей.
     *
     * @return void
     */
    public function __construct(?ModuleManager $manager = null)
    {
        $this->manager = $manager;
    }
}