<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Config\Exception;

use Gm\Exception;

/**
 * Исключение вызываемое при отсутствии файла кофигурации.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Config\Exception
 * @since 2.0
 */
class FileNotFoundException extends Exception\BootstrapException
{
}
