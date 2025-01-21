<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Data\Model;

use Gm;
use Closure;
use Gm\Db\Sql\Where;
use Gm\Stdlib\BaseObject;
use Gm\Db\Adapter\Adapter;
use Gm\Db\Adapter\Driver\AbstractCommand;

/**
 * Модель данных является базовым классом для всех классов-наследников модели.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Data\Model
 * @since 2.0
 */
class BaseModel extends BaseObject
{
    /**
     * Возвращает адаптера подключения к базе данных.
     * 
     * @return Adapter
     */
    public function getDb(): Adapter
    {
        return Gm::$app->db;
    }

    /**
     * Сбрасывает автоинкремент первичного ключа таблицы к указанному значению.
     * 
     * @param int|string $increment Значение автоинкремента первичного ключа.
     * @param string $tableName Имя таблицы (по умолчанию `null`).
     * 
     * @return void
     */
    public function resetIncrement(int|string $increment = 1, string $tableName = null): void
    {
        $this->getDb()
            ->createCommand()
                ->resetIncrement($tableName, $increment)
                ->execute();
    }

    /**
     * Удаляет записи из таблицы.
     * 
     * @param Where|Closure|string|array $where Условие выполнения запроса.
     * @param string $table Имя таблицы (по умолчанию `null`).
     * 
     * @return false|int Если значение `false`, ошибка выполнения запроса. Иначе, 
     *     количество удалённых записей.
     */
    public function deleteRecord(Where|Closure|string|array $where, string $tableName = null): false|int
    {
        /** @var AbstractCommand $command */
        $command = $this->getDb()
            ->createCommand()
                ->delete($tableName, $where)
                ->execute();
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }

    /**
     * Обновляет записи таблицы.
     * 
     * @param array $columns Cтолбцы таблицы с их значениями в виде пар "ключ - значение".
     * @param Where|Closure|string|array $where Условие выполнения запроса (по умолчанию `null`).
     * @param string $table Имя таблицы (по умолчанию `null`).
     * 
     * @return false|int Если значение `false`, ошибка выполнения запроса. Иначе количество 
     *     обновленных записей.
     */
    public function updateRecord(
        array $columns, 
        Where|Closure|string|array $where = null, 
        string $tableName = null
    ): false|int
    {
        /** @var AbstractCommand $command */
        $command = $this->getDb()
            ->createCommand()
                ->update($tableName, $columns, $where)
                ->execute();
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }

    /**
     * Добавляет запись.
     * 
     * @param array $columns Имена столбцов таблицы с их значениями в виде пар "ключ - значение".
     * @param string $table Имя таблицы (по умолчанию `null`).
     * 
     * @return int|string Идентификатор добавленной записи.
     */
    public function insertRecord(array $columns, string $tableName = null): int|string
    {
        /** @var Adapter $db */
        $db = $this->getDb();
        $db->createCommand()
            ->insert($tableName, $columns)
            ->execute();
        return $db->getConnection()->getLastGeneratedValue();
    }

    /**
     * Выбирает все строки по указанной инструкции SQL из результирующего набора и 
     * помещает их в объект, ассоциативный массив, обычный массив или в оба.
     * 
     * Возвращаемый результат определяется видом записей {@see AbstractCommand::$fetchMode}.

     * @param string $sql Инструкция SQL.
     * 
     * @return array
     */
    public function selectBySql(string $sql): array
    {
        return $this->getDb()
            ->createCommand($sql)
                ->queryAll();
    }
}
