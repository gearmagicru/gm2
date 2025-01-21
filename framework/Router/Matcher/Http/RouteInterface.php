<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Router\Matcher\Http;

/**
 * Интерфейс правила сопоставления маршрута модуля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Router\Matcher\Http
 * @since 2.0
 */
interface RouteInterface
{
    /**
     * Создаёт новое сопоставление маршрута с указанными параметрами.
     * 
     * @param array $options Параметры сопоставления маршрута.
     */
    public static function factory(array $options): static;

    /**
     * Определяет параметры сопоставления маршрута.
     * 
     * @param array $options Параметры сопоставления маршрута.
     */
    public function defineOptions(array $options): void;

    /**
     * Сопоставляет маршрут с указанными параметрами.
     * 
     * @return mixed Возвращает значение `false`, если сопоставление не 
     *     успешно. Иначе, результат сопоставления. Если результатом будет `null`,
     *     сопоставление частично успешно (нет смысла далее делать проверки, если это 
     *     выполняется перебором).
     */
    public function match(): mixed;
}
