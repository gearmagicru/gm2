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
 * Предикат "NotLike" для инструкции SQL "expression NOT LIKE pattern [ESCAPE 'escape_char']".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Predicate
 * @since 2.0
 */
class NotLike extends Like
{
    /**
     * {@inheritdoc}
     */
    protected string $specification = '%1$s NOT LIKE %2$s';
}
