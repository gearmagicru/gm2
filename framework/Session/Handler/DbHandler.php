<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Session\Handler;

use Gm;
use Gm\Helper\Str;
use Gm\Db\Adapter\Adapter;

/**
 * Обработчик сессии с использованием подключения к базе данных.
 * 
 * По умолчанию DbHandler хранит данные сессии в таблице БД с именем `{{session}}`. 
 * Эта таблица должна быть создана заранее.
 * 
 * В следующем примере показано, как настроить сессию приложения для использования 
 * обработчика DbHandler. Добавьте следующее в файл конфигурации служб `services.config.php` 
 * вашего приложения, раздел службы `session`:
 * ```php
 * [
 *     'session' => [
 *         'class'   => '\Gm\Session\Session',
 *         'handler' => [
 *             'class'     => '\Gm\Session\Handler\DbHandler',
 *             'tableName' => '{{session}}'
 *         ]
 *     ]
 * ]
 * ```
 * 
 * Для подключения к базе данных используют службу "db". Доступ к ней можно получить 
 * через `Gm::$app->db` или для текущего класса `DbHandler::getDb()`.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Session\Handler
 * @since 2.0
 */
class DbHandler extends AbstractHandler
{
    /**
     * Имя таблицы для хранения сессии в базе данных.
     * 
     * Таблица должна быть предварительно создана следующим образом:
     * ```sql
     * CREATE TABLE session
     * (
     *     id CHAR(40) NOT NULL PRIMARY KEY,
     *     expire INTEGER,
     *     data BLOB
     * )
     * ```
     * где "BLOB" относится к типу BLOB предпочитаемой СУБД. Ниже представлен тип 
     * BLOB, который можно использовать для некоторых популярных СУБД:
     * 
     * - MySQL: LONGBLOB
     * - PostgreSQL: BYTEA
     * - MSSQL: BLOB
     * 
     * Обратите внимание, что в соответствии с настройкой php.ini для `session.hash_function` 
     * может потребоваться указать длину столбца `id`. Например, если `session.hash_function = sha256`, 
     * необходимо использовать длину 64 вместо 40 байт.
     * 
     * @var string
     */
    public string $tableName = '{{session}}';

    /**
     * Возвращает указатель на экземпляр класса адаптера подключения к базе данных.
     * 
     * @return Adapter
     */
    public function getDb(): Adapter
    {
        return Gm::$services->getAs('db');
    }

    /**
     * {@inheritdoc}
     */
    public function read(string $id): string|false
    {
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = $this->getDb()->createCommand();
        $command->select($this->tableName, ['*'], ['id' => $id]);
        $data = $command->queryOne();
        return $data === null ? '' : Str::stripBracketSlashes($data['data']);
    }

    /**
     * {@inheritdoc}
     */
    public function write(string $id, string $data): bool
    {
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = $this->getDb()->createCommand();
        $command->replace(
            $this->tableName,
            [
                'id'     => $id,
                'data'   => Str::addBracketSlashes($data), 
                'expire' => time()
            ]
        );
        $command->execute();
        return $command->getResult() > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(string $id): bool
    {
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = $this->getDb()->createCommand();
        $command->delete($this->tableName, ['id' => $id]);
        $command->execute();
        return $command->getResult() === true ? $command->getAffectedRows() > 0 : false;
    }

    /**
     * {@inheritdoc}
     */
    public function gc(int $maxLifetime): int|false
    {
        $time = time() - $maxLifetime;
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = $this->getDb()->createCommand();
        $command->delete($this->tableName, "expire < $time");
        $command->execute();
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }
}
