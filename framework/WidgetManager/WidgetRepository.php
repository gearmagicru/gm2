<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\WidgetManager;

use Gm\ModuleManager\BaseRepository;

/**
 * Класс репозитория виджетов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\WidgetManager
 * @since 2.0
 */
class WidgetRepository extends BaseRepository
{
    /**
     * Конструктор класса.
     * 
     * @param null|WidgetManager $manager Менеджер виджетов.
     * 
     * @return void
     */
    public function __construct(?WidgetManager $manager = null)
    {
        $this->manager = $manager;
    }
}
