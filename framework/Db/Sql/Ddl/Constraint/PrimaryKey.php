<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Ddl\Constraint;

/**
 * Класс первичного ключа PRIMARY KEY.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl\Constraint
 * @since 2.0
 */
class PrimaryKey extends AbstractConstraint
{
    /**
     * {@inheritdoc}
     */
    protected string $specification = 'PRIMARY KEY';
}
