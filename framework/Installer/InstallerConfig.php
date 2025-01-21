<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Installer;

use Gm;
use Gm\Config\Config;

/**
 * Конфигуратор установщика.
 * 
 * Сохраняет параметры полученные на каждом шаге установки.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Installer
 * @since 1.0
 */
class InstallerConfig extends Config
{
    /**
     * Удаляет / сбрасывает параметры, полученные на каждом шаге установки.
     * 
     * @return bool
     */
    public function reset(): bool
    {
        /** @var \Gm\Stdlib\Serializer $serializer */
        $serializer = $this->getSerializer();
        return $serializer->delete();
    }
}
