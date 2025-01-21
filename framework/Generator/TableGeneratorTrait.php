<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator;

use Gm\Db\Sql\Where;
use Gm\Db\Sql\Select;
use Gm\Data\Model\BaseModel;

/**
 * Трейт генерации записей таблицы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
trait  TableGeneratorTrait
{
    /**
     * Модель данных.
     * 
     * @var BaseModel
     */
    protected BaseModel $model;

    /**
     * Инициализация.
     * 
     * @return void
     */
    public function init(): void
    {
        $this->model = new BaseModel();
    }

    /**
     * Добавляет запись.
     * 
     * @param array $columns Имена столбцов таблицы с их значениями в виде пар "ключ - значение".
     * 
     * @return mixed Идентификатор добавленной записи.
     */
    public function addTableRow(array $columns)
    {
        return $this->model->insertRecord($columns, $this->tableName);
    }

    /**
     * Удаляет запись(и) по условию.
     * 
     * @param Where|\Closure|string|array $where Условие выполнения запроса.
     * 
     * @return bool|int Если `false`, ошибка выполнения запроса. Иначе, количество удалённых записей.
     */
    public function deleteTableRow($where)
    {
        return $this->model->deleteRecord($where, $this->tableName);
    }

    /**
     * Обновляет запись.
     * 
     * @param array $columns Имена полей с их значениями.
     * @param Where|\Closure|string|array $where Условие выполнения запроса (по умолчанию `null`).
     * 
     * @return bool|int Если `false`, ошибка выполнения запроса. Иначе количество 
     *     обновленных записей.
     */
    public function updateTableRow(array $columns, $where = null)
    {
        return $this->model->updateRecord($columns, $where, $this->tableName);
    }

    /**
     * Удаляет все записи.
     * 
     * @return void
     */
    public function clearTable()
    {
        $this->model->deleteRecord(null, $this->tableName);
        $this->model->resetIncrement(1, $this->tableName);
    }

    /**
     * Возвращает все записи текущей таблицы с указанием ключа.
     * 
     * @param string $tableName Имя таблицы.
     * @param string|null $fetchKey Ключ возвращаемого ассоциативного массива записей. Если `null`, 
     *     результатом будет индексированный массив записей (по умолчачнию `null`).
     * @param array $columns Столбцы выборки текущей таблицы. Если вы не укажете столбцы 
     *     для выборки, то по умолчанию будет подставлено значение `['*']` (означающее "все столбцы"). 
     * @param Where|\Closure|string|array|null $where Условие выполнения запроса (по умолчанию `null`).
     * 
     * @return array Все записи текущей таблицы.
     */
    public function fetchTableRows(string $tableName, string $fetchKey = null, array $columns = ['*'], $where = null): array
    {
        /** @var Select $select */
        $select = new Select($tableName);
        $select->columns($columns);
        if ($where) {
            $select->where($where);
        }
        return $this->model
            ->getDb()
                ->createCommand($select)
                    ->queryAll($fetchKey);
    }

    /**
     * Возвращает сгруппированные записи по указанному полю текущей таблицы.
     * 
     * @param string $tableName Имя таблицы.
     * @param string|null $groupKey Имя поля для группирования записей таблицы.
     * @param array $columns Столбцы выборки текущей таблицы. Если вы не укажете столбцы 
     *     для выборки, то по умолчанию будет подставлено значение `['*']` (означающее "все столбцы"). 
     * @param Where|\Closure|string|array|null $where Условие выполнения запроса (по умолчанию `null`).
     * 
     * @return array Все записи текущей таблицы.
     */
    public function groupTableRows(string $tableName, string $groupKey = null, array $columns = ['*'], $where = null): array
    {
        /** @var Select $select */
        $select = new Select($tableName);
        $select->columns($columns);
        if ($where) {
            $select->where($where);
        }
        return $this->model
            ->getDb()
                ->createCommand($select)
                    ->query()
                    ->fetchToGroups($groupKey);
    }
}
