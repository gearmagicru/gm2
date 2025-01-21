<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Cache\Storage\Adapter;

use Gm\Session\Container as SessionContainer;

/**
 * Параметры адаптера сессии.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage\Adapter
 * @since 2.0
 */
class SessionOptions extends AdapterOptions
{
    /**
     * Контейнер сессии
     *
     * @var null|SessionContainer
     */
    protected $sessionContainer = null;

    /**
     * Установка контейнера сессии
     *
     * @param  null|SessionContainer $sessionContainer
     * @return SessionOptions
     */
    public function setSessionContainer(SessionContainer $sessionContainer = null)
    {
        if ($this->sessionContainer != $sessionContainer) {
            $this->sessionContainer = $sessionContainer;
        }
        return $this;
    }

    /**
     * Возвращение контейнера сессии
     *
     * @return null|SessionContainer
     */
    public function getSessionContainer()
    {
        return $this->sessionContainer;
    }
}
