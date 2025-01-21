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
 * Класс столбца с типом данных "BOOLEAN" (псевдонимом для типа TINYINT(1)).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl\Column
 * @since 2.0
 */
class Boolean extends Column
{
    /**
     * {@inheritdoc}
     */
    protected string $type = 'BOOLEAN';

    /**
     * {@inheritdoc}
     */
    public function setNullable(bool $nullable): static
    {
        return parent::setNullable(false);
    }
}
