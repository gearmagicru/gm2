<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\I18n\ISO;

use Gm\ServiceManager\AbstractManager;

/**
 * Менеджер обозначений ISO.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\I18n\ISO
 * @since 2.0
 */
class ISO extends AbstractManager
{
    /**
     * {@inheritdoc}
     */
    protected array $invokableClasses = [
        'languages' => '\Gm\I18n\ISO\Adapter\Languages',
        'countries' => '\Gm\I18n\ISO\Adapter\Countries',
        'locales'   => '\Gm\I18n\ISO\Adapter\Locales',
        'scripts'   => '\Gm\I18n\ISO\Adapter\Scripts'
    ];

    /**
     * Возвращает значения по указанному ключу (магический метод).
     * 
     * @param string $key Ключ.
     * 
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }
}
