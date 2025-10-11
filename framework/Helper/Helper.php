<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015-2025 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Helper;

use Gm\Mvc\Application;

/**
 * Базовый вспомогательный класс.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Helper
 * @since 2.0
 */
class Helper
{
    /**
     * Экземпляр приложения.
     * 
     * @see Helper::setApplication()
     * 
     * @var Application|null
     */
    protected static ?Application $app = null;

    /**
     * Возвращает экземпляр приложения.
     *
     * @return Application|null
     */
    public static function getApplication(): ?Application
    {
        return static::$app;
    }

    /**
     * Устанавливает экземпляр приложения.
     * 
     * @see \Gm\Mvc\Application::initHelper()
     * 
     * @param Application|null $app
     * 
     * @return void
     */
    public static function setApplication(?Application $app): void
    {
        static::$app = $app;
    }
}
