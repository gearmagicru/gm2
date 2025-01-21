<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Predicate;

use Gm\Db\Sql\Expression as BaseExpression;

/**
 * Предикат "Expression" для SQL инструкции.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Predicate
 * @since 2.0
 */
class Expression extends BaseExpression implements PredicateInterface
{
    /**
     * Конструктор класса.
     *
     * @param string $expression Выражение.
     * @param int|float|bool|string|array|null $valueParameter Параметры выражения.
     */
    public function __construct(
        string $expression = null, 
        mixed $valueParameter = null /*[, $valueParameter, ... ]*/)
    {
        if ($expression) {
            $this->setExpression($expression);
        }

        $this->setParameters(is_array($valueParameter) ? $valueParameter : array_slice(func_get_args(), 1));
    }
}
