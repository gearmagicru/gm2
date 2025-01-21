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
 * Класс столбца с типом данных "VARCHAR" (строка переменной длины).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl
 * @since 2.0
 */
class Varchar extends AbstractLengthColumn
{
    /**
     * {@inheritdoc}
     */
    protected string $type = 'VARCHAR';
}
