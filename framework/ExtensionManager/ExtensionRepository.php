<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\ExtensionManager;

use Gm\ModuleManager\BaseRepository;

/**
 * Класс репозитория расширений модулей.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\ExtensionManager
 * @since 2.0
 */
class ExtensionRepository extends BaseRepository
{
    /**
     * Конструктор класса.
     *
     * @param null|ExtensionManager $manager Менеджер расширений.
     *
     * @return void
     */
    public function __construct(?ExtensionManager $manager = null)
    {
        $this->manager = $manager;
    }
}
