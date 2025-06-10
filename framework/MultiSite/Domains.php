<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\MultiSite;

use Gm\Stdlib\Collection;

/**
 * Класс коллекции (карты) доменов.
 * 
 * В коллекции домены представлены в виде пар "ключ - значение". Где ключа - домен,
 * а значение - уникальный идентификатор сайта.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\MultiSite
 * @since 2.0
 */
class Domains extends Collection
{
    /**
     * Удаляет домены по указанным идентификаторам сайта.
     *
     * @param string|array $id Уникальный идентификатор(ы) сайта.
     * 
     * @return static
     */
    public function removeBySiteId(string $id): static
    {
        foreach ($this->container as $domain => $siteId) {
            if ($id === $siteId) {
                unset($this->container[$domain]);
            }
        }
        return $this;
    }
}
