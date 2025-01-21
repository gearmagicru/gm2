<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Ddl\Constraint;

use Gm\Db\Sql\ExpressionInterface;

/**
 * Интерфейс ограничений.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl\Constraint
 * @since 2.0
 */
interface ConstraintInterface extends ExpressionInterface
{
    /**
     * Возвращает столбцы таблицы.
     * 
     * @return array
     */
    public function getColumns(): array;
}
