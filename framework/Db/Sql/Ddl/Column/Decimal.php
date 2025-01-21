<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Ddl\Column;

/**
 * Класс столбца с типом данных "DECIMAL" (числа с фиксированной точностью).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl
 * @since 2.0
 */
class Decimal extends AbstractPrecisionColumn
{
    /**
     * {@inheritdoc}
     */
    protected string $type = 'DECIMAL';
}
