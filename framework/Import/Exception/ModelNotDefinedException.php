<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Import\Exception;

use Gm\Exception\NotDefinedException;

/**
 * Исключение возникающие при отсутствии модели данных (активной записи).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Import\Exception
 * @since 2.0
 */
class ModelNotDefinedException extends NotDefinedException
{
}
