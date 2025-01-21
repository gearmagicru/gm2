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
 * Класс столбца с типом данных "BIGINT" (целые числа от -9 223 372 036 854 775 808 
 * до 9 223 372 036 854 775 807).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl\Column
 * @since 2.0
 */
class BigInteger extends Integer
{
    /**
     * {@inheritdoc}
     */
    protected string $type = 'BIGINT';
}
