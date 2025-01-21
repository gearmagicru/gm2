<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Sql\Ddl;

use Gm\Db\Sql\AbstractSql;
use Gm\Db\Adapter\Platform\PlatformInterface;

/**
 * Класс DropTable создаёт инструкцию SQL "DROP TABLE" для удаления таблицы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl
 * @since 2.0
 */
class DropTable extends AbstractSql implements SqlInterface
{
    /**
     * @var string Ключ "table" (удаление таблицы) в спецификации.
     */
    public const TABLE = 'table';

    /**
     * {@inheritdoc}
     */
    protected array $specifications = [
        self::TABLE => 'DROP TABLE %1$s'
    ];

    /**
     * Имя таблицы.
     * 
     * @see DropTable::__construct()
     * 
     * @var string
     */
    protected string $table = '';

    /**
     * Конструктор класса.
     * 
     * @param string $table Имя таблицы (по умолчанию '').
     */
    public function __construct(string $table = '')
    {
        $this->table = $table;
    }

    /**
     * Возвращает выражение TABLE для инструкции SQL.
     * 
     * @param PlatformInterface $platform Платформа адаптера.
     * 
     * @return array
     */
    protected function processTable(PlatformInterface $adapterPlatform): array
    {
        return [$adapterPlatform->quoteIdentifier($this->table)];
    }
}
