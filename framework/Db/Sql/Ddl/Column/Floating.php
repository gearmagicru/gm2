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
 * Класс столбца с типом данных "FLOAT" (дробные числа с плавающей точкой одинарной 
 * точности).
 *
 * Невозможно назвать класс "float", начиная с PHP 7, так как это зарезервированное 
 * ключевое слово.
 * Следовательно, "floating" с типом "FLOAT".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl
 * @since 2.0
 */
class Floating extends AbstractPrecisionColumn
{
    /**
     * {@inheritdoc}
     */
    protected string $type = 'FLOAT';
}
