<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Installer;

/**
 * Маршрутизатор запросов установщика.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Installer
 * @since 1.0
 */
class InstallerRouter
{
    /**
     * Маршрут (сопоставления) установщика.
     *
     * @var string
     */
    public string $match = '';

    /**
     * Маршрут запроса.
     * 
     * @see InstallerRouter::parse()
     * 
     * @var string
     */
    public string $route = '';

    /**
     * Конструктор класса.
     *
     * @param string $match
     * 
     * @return void
     */
    public function __construct(string $match)
    {
        $this->match = $match;

        $this->parse();
    }

    /**
     * Разбор маршрута.
     *
     * @return void
     */
    protected function parse(): void
    {
        $request = parse_url($_SERVER['REQUEST_URI'] ?? '');

        if (isset($request['path'])) {
            $this->route = trim($request['path'], '/');
        }
    }

    /**
     * Сопоставление маршрута установщика с указанным маршрутом.
     *
     * @param string|null $route Сопоставляемый маршрут с маршрутом установщика 
     *     (по умолчанию `null`).
     * 
     * @return bool Возвращает значение `true`, если это маршрут установщика.
     */
    public function isMatch(?string $route = null): bool
    {
        if ($route === null) {
            $route = $this->match;
        }
        return $this->route === $route;
    }
}
