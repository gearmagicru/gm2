<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Adapter\Platform;

use PDO;
use mysqli as PhpMySqli;
use Gm\Db\Adapter\Driver\DriverInterface;
use Gm\Db\Adapter\Driver\MySqli\Connection;

/**
 * Платформа адаптера драйвера "MySqli".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Db\Adapter\Platform
 * @since 2.0
 */
class MySqli extends AbstractPlatform
{
    /**
     * {@inheritdoc}
     */
    public string $dateTimeFormat = 'Y-m-d H:i:s';

    /**
     * {@inheritdoc}
     */
    public string $dateFormat = 'Y-m-d';

    /**
     * {@inheritdoc}
     */
    public string $timeFormat = 'H:i:s';

    /**
     * {@inheritdoc}
     */
    public array $quoteIdentifier = ['`', '`'];

    /**
     * {@inheritdoc}
     */
    public string $quoteIdentifierTo = '``';

    /**
     * @see MySqli::setDriver()
     * 
     * @var PhpMySqli|PDO|DriverInterface
     */
    protected PhpMySqli|PDO|DriverInterface $resource;

    /**
     * Конструктор класса.
     * 
     * @param null|Connection $driver Соединение с помощью драйвера "MySqli" к серверу базы данных.
     */
    public function __construct(Connection $driver = null)
    {
        if ($driver) {
            $this->setDriver($driver);
        }
    }

    /**
     * Установка драйвера подключения к базе данных.
     * 
     * @param Connection $driver Соединение с помощью драйвера "MySqli" к серверу базы данных.
     * 
     * @return $this
     */
    public function setDriver(Connection $driver): static
    {
        $this->resource = $driver->getResource();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'MySQL';
    }

    /**
     * {@inheritdoc}
     */
    public function quoteIdentifierChain(string|array $identifierChain): string
    {
        return '`' . implode('`.`', (array) str_replace('`', '``', $identifierChain)) . '`';
    }

    /**
     * {@inheritdoc}
     */
    public function quoteValue(string $value): string
    {
        if ($this->resource instanceof DriverInterface) {
            $this->resource = $this->resource->getConnection()->getResource();
        }
        if ($this->resource instanceof PhpMySqli) {
            return '\'' . $this->resource->real_escape_string($value) . '\'';
        }
        if ($this->resource instanceof PDO) {
            return $this->resource->quote($value);
        }
        return parent::quoteValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function quoteTrustedValue(string $value): string
    {
        if ($this->resource instanceof DriverInterface) {
            $this->resource = $this->resource->getConnection()->getResource();
        }
        if ($this->resource instanceof PhpMySqli) {
            return '\'' . $this->resource->real_escape_string($value) . '\'';
        }
        return parent::quoteTrustedValue($value);
    }
}
