<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator;

use Gm;

/**
 * Класс загрузчика произвольных данных шаблона.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
class Loader
{
    /**
     * Имя файла шаблона в формате (*.php, *.xml).
     * 
     * @var string
     */
    protected ?string $filename = null;

    /**
     * Конструктор класса.
     * 
     * @param null|string $filename Имя файла шаблона.
     */
    public function __construct(?string $filename = null)
    {
        $this->filename = $filename;
    }

    /**
     * Загружает произвольные значения шаблона.
     * 
     * @param null|string $filename Имя файла шаблона в формате (*.php, *.xml). Если 
     *     имя шаблона не указано, то используется {@see Loader::$filename}.
     * 
     * @return mixed
     * 
     * @throws Exception\PatternNotLoadException Невозможно загрузить произвольные значения шаблона.
     */
    public function load(?string $filename = null): array
    {
        if ($filename === null) {
            $filename = $this->filename;
        }

        if (empty($filename)) {
            throw new Exception\PatternNotLoadException('Can not include pattern, filename no set.');
        }

        if (!file_exists(__DIR__ . DS . $filename)) {
            throw new Exception\PatternNotLoadException(
                sprintf('Can not include pattern file "%s".', $filename)
            );
        }

        $method = 'load' . strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
        if (!method_exists($this, $method)) {
            throw new Exception\PatternNotLoadException('File extension is incorrect.');
        }
        return $this->$method(__DIR__ . DS . $filename);
    }

    /**
     * Загружает произвольные значения шаблона в формате PHP.
     * 
     * @param string $filename Имя файла шаблона в формате PHP.
     * 
     * @return array
     * 
     * @throws Exception\PatternNotLoadException Невозможно загрузить произвольные значения шаблона.
     */
    public function loadPHP(string $filename): array
    {
        $data = include($filename);
        if ($data === false) {
            throw new Exception\PatternNotLoadException(
                sprintf('Can not include pattern file "%s"', $filename)
            );
        }
        return $data;
    }

    /**
     * Загружает произвольные значения шаблона в формате XML.
     * 
     * @param string $filename Имя файла шаблона в формате XML.
     * 
     * @return array
     * 
     * @throws Exception\PatternNotLoadException Невозможно загрузить произвольные значения шаблона.
     */
    public function loadXML(string $filename): array
    {
        $xml = simplexml_load_file($filename);
        if (empty($xml->row) ) {
            throw new Exception\PatternNotLoadException(
                sprintf('XML tag "name" not exists in pattern file "%s"', $filename)
            );
        }
        $row = (array) $xml->row[0];
        $keys = array_keys($row);
        $data = [];
        if ($keys[0] === 0) {
            foreach ($xml->row as $row) {
                $data[] = (string) $row;
            }
        } else {
            foreach ($xml->row as $row) {
                $data[] = (array) $row;
            }
        }
        return $data;
    }
}
