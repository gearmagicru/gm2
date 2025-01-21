<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Cache\Storage\Adapter;

use Gm\Cache\Exception;
use Gm\Cache\Storage\StorageInterface;
use \Zend\Stdlib\AbstractOptions;
use \Zend\Stdlib\ErrorHandler;

/**
 * Параметры адаптера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Cache\Storage\Adapter
 * @since 2.0
 */
class AdapterOptions extends AbstractOptions
{
    /**
     * Адаптер, использующий эти параметры
     *
     * @var null|StorageInterface
     */
    protected $adapter;

    /**
     * Проверить ключ на шаблон
     *
     * @var string
     */
    protected $keyPattern = '';

    /**
     * Опция пространства имен
     *
     * @var string
     */
    protected $namespace = 'gcache';

    /**
     * Опция чтения
     *
     * @var bool
     */
    protected $readable = true;

    /**
     * TTL опция
     *
     * @var int|float 0 means infinite or maximum of adapter
     */
    protected $ttl = 0;

    /**
     * Опция записи
     *
     * @var bool
     */
    protected $writable = true;

    /**
     * Адаптер с использованием этого экземпляра
     *
     * @param  StorageInterface|null $adapter
     * @return AdapterOptions
     */
    public function setAdapter(StorageInterface $adapter = null)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Установка шаблона ключа
     *
     * @param  null|string $keyPattern шаблон ключа
     * @throws Exception\InvalidArgumentException
     * @return AdapterOptions
     */
    public function setKeyPattern($keyPattern)
    {
        $keyPattern = (string) $keyPattern;
        if ($this->keyPattern !== $keyPattern) {
            // validate pattern
            if ($keyPattern !== '') {
                ErrorHandler::start(E_WARNING);
                $result = preg_match($keyPattern, '');
                $error = ErrorHandler::stop();
                if ($result === false) {
                    throw new Exception\InvalidArgumentException(sprintf(
                        'Invalid pattern "%s"%s',
                        $keyPattern,
                        ($error ? ': ' . $error->getMessage() : '')
                    ), 0, $error);
                }
            }
            $this->keyPattern = $keyPattern;
        }
        return $this;
    }

    /**
     * Возвращение шаблона ключа
     *
     * @return string
     */
    public function getKeyPattern()
    {
        return $this->keyPattern;
    }

    /**
     * Установка namespace
     *
     * @param  string $namespace
     * @return AdapterOptions
     */
    public function setNamespace($namespace)
    {
        $namespace = (string) $namespace;
        if ($this->namespace !== $namespace) {
            $this->namespace = $namespace;
        }
        return $this;
    }

    /**
     * Возвращение namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Установка на чтение
     *
     * @param bool $readable на чтение
     * @return AbstractAdapter
     */
    public function setReadable($readable)
    {
        $readable = (bool) $readable;
        if ($this->readable !== $readable) {
            $this->readable = $readable;
        }
        return $this;
    }

    /**
     * Возвращение доступа не чтение из кэша
     *
     * @return bool
     */
    public function getReadable()
    {
        return $this->readable;
    }

    /**
     * Установка опции ttl
     *
     * @param  int|float $ttl
     * @return AdapterOptions
     */
    public function setTtl($ttl)
    {
        $this->normalizeTtl($ttl);
        if ($this->ttl !== $ttl) {
            $this->ttl = $ttl;
        }
        return $this;
    }

    /**
     * Возвращение опции ttl
     *
     * @return float
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Установка режима записи в кэш
     *
     * @param bool $writable на запись
     * @return AdapterOptions
     */
    public function setWritable($writable)
    {
        $writable = (bool) $writable;
        if ($this->writable !== $writable) {
            $this->writable = $writable;
        }
        return $this;
    }

    /**
     * Проверка на запись данных в кэш
     *
     * @return bool
     */
    public function getWritable()
    {
        return $this->writable;
    }

    /**
     * Валидация и нормализация TTL.
     *
     * @param  int|float $ttl
     * @throws Exception\InvalidArgumentException
     * @return void
     */
    protected function normalizeTtl(&$ttl)
    {
        if (!is_int($ttl)) {
            $ttl = (float) $ttl;

            if ($ttl === (float) (int) $ttl) {
                $ttl = (int) $ttl;
            }
        }

        if ($ttl < 0) {
            throw new Exception\InvalidArgumentException("TTL can't be negative");
        }
    }
}
