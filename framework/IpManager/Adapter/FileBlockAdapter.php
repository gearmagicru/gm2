<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\IpManager\Adapter;

use Gm;
use Gm\Config\Config;
use Gm\Db\Adapter\Driver\Exception\CommandException;

/**
 * Класс адаптера, списка временно заблокированных IP-адресов в файле.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\IpManager\Adapter
 * @since 2.0
 */
class FileBlockAdapter extends AbstractBlockAdapter
{
    /**
     * Список временно заблокированных IP-адресов.
     * 
     * @var Config
     */
    public Config $data;

    /**
     * Конструктор класса.
     * 
     * @return void
     */
    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->data = new Config($options['filename'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $ipInfo, ?string $ipAddress = null): bool
    {
        $ipInfo['ip'] = $ipAddress ?: $this->ipAddress;
        $id = ip2long($ipInfo['ip']);

        $this->data
            ->set($id, $ipInfo)
            ->save();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $ipInfo, ?string $ipAddress = null): bool
    {
        $this->resetError();
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = Gm::$app->db->createCommand();
        try {
            $command->update($this->options['tableName'], $ipInfo, ['id' => ip2long($ipAddress ?: $this->ipAddress)]);
            $command->execute();
        } catch (CommandException $e) {
            $this->error = $command->getError();
        }

        if ($this->error) {
            return false;
        }
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }

    /**
     * Выполняет обновление и добавление информации о записи IP-адреса.
     * 
     * @return bool Возвращает значение `false`, если информация о записи IP-адреса не 
     *     обновлена или не добавлена.
     */
    public function save(): bool
    {
        if ($this->id)
            return $this->update($this->ipInfo, $this->ip);
        else
            return $this->add($this->ipInfo, $this->ip);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(?string $ipAddress = null): bool
    {
        $this->resetError();
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = Gm::$app->db->createCommand();
        try {
            $command->delete($this->options['tableName'], ['id' => ip2long($ipAddress ?: $this->ipAddress)]);
            $command->execute();
        } catch (CommandException $e) {
            $this->error = $command->getError();
        }

        if ($this->error) {
            return false;
        }
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }

    /**
     * {@inheritdoc}
     */
    public function get(?string $ipAddress = null): mixed
    {
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $select = Gm::$app->db
            ->select($this->options['tableName'])
            ->columns(['*'])
            ->where(['id' => ip2long($ipAddress ?: $this->ipAddress)]);
        $result = Gm::$app->db->createCommand($select)->queryOne();
        if ($result) {
            $this->ipInfo = $result;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): bool
    {
        $this->resetError();
        /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
        $command = Gm::$app->db->createCommand();
        try {
            $command->delete($this->options['tableName']);
            $command->execute();
        } catch (CommandException $e) {
            $this->error = $command->getError();
        }

        if ($this->error) {
            return false;
        }
        return $command->getResult() === true ? $command->getAffectedRows() : false;
    }
}
