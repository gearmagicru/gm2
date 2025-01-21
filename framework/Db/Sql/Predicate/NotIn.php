<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Predicate;

/**
 * Предикат "NotIn" для инструкции SQL "expression NOT IN (value,...)".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Predicate
 * @since 2.0
 */
class NotIn extends In
{
    /**
     * {@inheritdoc}
     */
    protected string $specification = '%s NOT IN %s';
}
