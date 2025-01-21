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
 * Класс ограничения CHECK.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl\Constraint
 * @since 2.0
 */
class Check extends AbstractConstraint
{
    /**
     * Выражение.
     * 
     * @see Check::__construct()
     * 
     * @var ExpressionInterface|string
     */
    protected ExpressionInterface|string $expression;

    /**
     * {@inheritdoc}
     */
    protected string $specification = 'CHECK (%s)';

    /**
     * Конструктор класса.
     * 
     * @param ExpressionInterface|string $expression Выражение.
     * @param string $name Название.
     */
    public function __construct(ExpressionInterface|string $expression, string $name)
    {
        $this->expression = $expression;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpressionData(): array
    {
        $newSpecTypes = [self::TYPE_LITERAL];
        $values       = [$this->expression];
        $newSpec      = '';

        if ($this->name) {
            $newSpec .= $this->namedSpecification;

            array_unshift($values, $this->name);
            array_unshift($newSpecTypes, self::TYPE_IDENTIFIER);
        }
        return [
            [
                $newSpec . $this->specification,
                $values,
                $newSpecTypes
            ]
        ];
    }
}
