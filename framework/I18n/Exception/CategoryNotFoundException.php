<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\I18n\Exception;

use Gm\Exception\NotDefinedException;

/**
 * Исключение возникающие при отсутствии категории локализации сообщения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\I18n\Exception
 * @since 2.0
 */
class CategoryNotFoundException extends NotDefinedException
{
}
