<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * 
 * 
 * 
 * This code Imported and modified from Zend Framework (http://framework.zend.com/)
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Predicate;

/**
 * Предикат "IsNotNull", как условие для инструкции SQL "expression IS NOT NULL".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Predicate
 * @since 2.0
 */
class IsNotNull extends IsNull
{
    /**
     * {@inheritdoc}
     */
    protected $specification = '%1$s IS NOT NULL';
}
