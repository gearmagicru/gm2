<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Session\Storage;

use Gm;
use Gm\Session\AbstractContainer;
use Gm\Session\Session;

/**
 * Хранилище (место хранения) контейнера сессии.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Session\Storage
 * @since 2.0
 */
class SessionStorage extends AbstractContainer  implements StorageInterface
{
    /**
     * Конструктор класса.
     *
     * @param null|Session $session Сессия.
     * 
     * @return void
     * 
     * @throws Exception\InvalidArgumentException Имя, переданное контейнеру, недействительно.
     */
    public function __construct(Session $session = null)
    {
        $this->setName($this->name);
        $this->setSession($session);
        $this->init();
    }

    /**
     * {@inheritdoc}
     */
    public function read(): mixed
    {
        return $this->all();
    }

    /**
     * {@inheritdoc}
     * 
     * @return $this
     */
    public function write(mixed $content): static
    {
        $this->setAll($content);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function isInit(): bool
    {
        return Gm::$services->getAs('session')->hasSessionId();
    }
}
