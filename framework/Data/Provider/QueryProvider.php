<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Data\Provider;

use Gm;
use Gm\Db\Sql\Select;
use Gm\Db\ActiveRecord;
use Gm\Db\Adapter\Driver\AbstractCommand;
use Gm\Exception\InvalidConfigException;

/**
 * QueryProvider реализует поставщик данных с использованием объекта запроса.
 * 
 * В качестве объекта запроса применяется оператор SQL {@see \Gm\Db\Sql\Select} или 
 * активная запись {@see \Gm\Db\ActiveRecord}.
 * 
 * QueryProvider, как и другие поставщики данных, поддерживает разбиение элементов 
 * данных на страницы и сортировку. Для изменения вывода количества записей на странице 
 * или их сортировки, нет необходимости использовать операторы SQL, такие как: "LIMIT" 
 * и "ORDER BY".
 * 
 * Пример:
 * ```php
 * $select = new Select('{{article}}');
 * $select->quantifier(new \Gm\Db\Sql\Expression('SQL_CALC_FOUND_ROWS'));
 * $select->columns(['*']);
 * 
 * $provider = new QueryProvider([
 *     'query' => $select,
 *     'sort' => [
 *         'default' => 'date,a;header,d',
 *         'filter'  => ['date' => 'publish_date', 'header' => 'header']
 *     ],
 *     'pagination' => [
 *         'limit' => 10,
 *     ]
 * ]);
 * // возвращает элементы для текущей страницы
 * $items = $provider->getItems();
 * ```
 * Для определения общего количества элементов используется `$select->quantifier()`,
 * или можно указать значение свойству `totalCount` (например, `'pagination' => [
 * 'totalCount' => 100]`).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Data\Provider
 * @since 2.0
 */
class QueryProvider extends BaseProvider
{
    /**
     * Объект запроса.
     * 
     * @var Select|ActiveRecord|null
     */
    public Select|ActiveRecord|null $query = null;

    /**
     * Имя метода или функции для предварительной обработки элементов данных перед 
     * их выводом.
     * 
     * Например: 'fooBar' или `[$this, 'fooBar']`.
     * 
     * @see QueryProvider::prepareItems()
     * @see https://www.php.net/manual/ru/function.call-user-func.php
     * 
     * @var string|array|null
     */
    public string|array|null $processItems = null;

    /**
     * @see BaseProvider::prepareItems()
     * 
     * @var AbstractCommand
     */
    protected AbstractCommand $command;

    /**
     * {@inheritdoc}
     */
    public function prepareTotalCount(): int
    {
        if ($this->items === null)
            return 0;
        else
            return $this->command->getFoundRows();
    }

    /**
     * {@inheritdoc}
     */
    public function prepareItems(): array
    {
        if (!$this->query instanceof Select && !$this->query instanceof ActiveRecord) {
            throw new InvalidConfigException(
                'The property "query" must be an instance of a class that implements the "\Gm\Db\Sql\Select" or its subclasses.'
            );
        }

        /** @var Pagination $pagination */
        $pagination = $this->getPagination();
        if ($pagination) {
            $this->query
                ->limit($pagination->getLimit())
                ->offset($pagination->getOffset());
        }

        // если сортировка доступна
        $sort = $this->getSort();
        if ($sort) {
            if ($order = $sort->getOrder()) {
                $this->query->order($order);
            }
        }

        $this->command = Gm::$app->db->createCommand($this->query);
        $items = $this->command->queryAll();

        if ($this->processItems !== null) {
            $items = call_user_func($this->processItems, $items);
        }
        return $items;
    }
}
