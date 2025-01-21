<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql;

/**
 * Интерфейс выражения в инструкции SQL.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql
 * @since 2.0
 */
interface ExpressionInterface
{
    public const TYPE_IDENTIFIER = 'identifier';
    public const TYPE_VALUE      = 'value';
    public const TYPE_LITERAL    = 'literal';
    public const TYPE_SELECT     = 'select';

    /**
     * Возвращает данные выражения.
     * 
     * Результат имеет вид:
     * ```php
     * [
     *     // строка в формате sprintf
     *     'specification',
     *     // значения для приведенной выше строки в формате sprintf
     *     ['foo' => 'bar', ...],
     *     // массив равной длины массиву значений с TYPE_IDENTIFIER или TYPE_VALUE для каждого значения
     *     [TYPE_IDENTIFIER, ...]
     * ]
     * ```
     * 
     * @return array<int, mixed>
     */
    public function getExpressionData(): array;
}
