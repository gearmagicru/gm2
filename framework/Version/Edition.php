<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Version;

/**
 * Версия редакции приложения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Version
 * @since 2.0
 */
class Edition extends BaseVersion
{
    /**
     * Код версии редакции.
     * 
     * Сокращенное уникальное название редакции приложения.
     * 
     * Например, если (международное) название редакции `$name = 'Start'`, 
     * то код может быть указан, как 'STR'.
     * 
     * @var string
     */
    public string $code = '';

    /**
     * Оригинальное название версии редакции приложения.
     * 
     * Это название применяется для страны разработчика.
     * 
     * Например, если (международное) название редакции приложения `$name = 'Start'`, 
     * то название в стране разработчика будет 'Старт' или на том языке, 
     * где зарегистрирован ваш продукт (редакция приложения).
     * 
     * @var string
     */
    public string $originalName = '';
}
