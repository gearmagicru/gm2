<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql;

use Gm\Db\Adapter\Platform\PlatformInterface;

/**
 * Интерфейс инструкции SQL.
 * 
 * @author Zend Framework (http://framework.zend.com/)
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Db\Adapter\Driver
 * @since 2.0
 */
interface SqlInterface
{
    /**
     * Получить строку SQL для оператора.
     *
     * @param PlatformInterface|null $adapterPlatform
     *
     * @return string
     */
    public function getSqlString(PlatformInterface $adapterPlatform = null): string;
}
