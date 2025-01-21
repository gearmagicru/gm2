<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator;

use Gm\Stdlib\BaseObject;

/**
 * Базовый класс генератора данных.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
class BaseGenerator extends BaseObject
{
    /**
     * Шаблонны случайных значений для генерации в виде пар "ключ - значение".
     * 
     * Где, "ключ" - имя шаблона, а "значение" - массив лучайных значений.
     * 
     * @var array
     */
    public array $patterns = [];

    /**
     * Имена файлов шаблонов с произвольными значениями.
     * 
     * Пример:
     * ```php
     * $this->patternNames['name'] = '\patterns\pattern.xml';
     * ``
     * где, "ключ" - имя шаблона, а "значение" - имя файла.
     * 
     * @see BaseGenerator::addPatternName()
     * 
     * @var array
     */
    protected array $patternNames = [];

    /**
     * Автозагрузка шаблонов с произвольными значениями.
     * 
     * @see BaseGenerator::init()
     * 
     * @var bool
     */
    protected bool $autoload = true;

    /**
     * Загрузчик произвольных значений шаблона.
     * 
     * @var Loader
     */
    protected Loader $loader;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        $this->loader = new Loader();

        parent::__construct($config);

        $this->init();
    }

    /**
     * Инициализация.
     * 
     * @return void
     */
    public function init(): void
    {
        if ($this->autoload) {
            foreach ($this->patternNames as $name => $filename) {
                $this->addPattern($name);
            }
        }
    }

    /**
     * Возвращает случайное значение из указанного шаблона значений.
     * 
     * @param string $name Имя шаблона.
     * @param string|null $subname Имя ключа (группы) произвольных значений шаблона 
     *     (по умолчанию `null`).
     * 
     * @return mixed Если значение `false`, то невозможно получить генерируемое значение.
     */
    public function random(string $name, string $subname = null): mixed
    {
        if ($subname) {
            if (!isset($this->patterns[$name][$subname])) {
                return false;
            }
            $pattern = &$this->patterns[$name][$subname];
        } else {
            if (!isset($this->patterns[$name])) {
                return false;
            }
            $pattern = &$this->patterns[$name];
        }
        $size = sizeof($pattern);
        if ($size == 0) {
            return false;
        }
        $index = rand(0, $size - 1);
        return $pattern[$index] ?? false;
    }

    /**
     * Возвращает следующие значение из шаблона.
     * 
     * @param int $index Индекс массива произвольных значений шаблона.
     * @param string $name Имя шаблона.
     * @param string|null $subname Имя ключа (группы) произвольных значений шаблона 
     *     (по умолчанию `null`).
     * 
     * @return mixed Если значение `false`, невозможно получить значение.
     */
    public function next(int &$index, string $name, string $subname = null): mixed
    {
        if ($subname) {
            if (!isset($this->patterns[$name][$subname])) {
                return false;
            }
            $pattern = &$this->patterns[$name][$subname];
        } else {
            if (!isset($this->patterns[$name])) {
                return false;
            }
            $pattern = &$this->patterns[$name];
        }
        $size = sizeof($pattern);
        if ($size == 0) {
            return false;
        }
        if ($index > ($size - 1)) {
            $index = 0;
        }
        $index++;
        return isset($pattern[$index - 1]) ? $pattern[$index - 1] : false;
    }

    /**
     * Генерирует случайные данные.
     * 
     * @return void
     */
    public function generate(): void
    {
    }

    /**
     * Добавляет имя шаблона.
     * 
     * @param string $name Имя шаблона.
     * @param string $filename Имя файла шаблона (*.php, *.xml).
     * 
     * @return void
     */
    public function addPatternName(string $name, string $filename) :void
    {
        $this->patternNames[$name] = $filename;
    }

    /**
     * Добавляет (загружает) произвольные значения в шаблон.
     * 
     * @param string $name Имя шаблона.
     * 
     * @return void
     * 
     * @throws Exception\PatternNotExistsException Указанное имя шаблона не существует.
     * @throws Exception\PatternNotLoadException Невозможно загрузить данные шаблона.
     */
    public function addPattern(string $name): void
    {
        if (!isset($this->patternNames[$name])) {
            throw new Exception\PatternNotExistsException(
                sprintf('Pattern "%s" not exists', $name)
            );
        }
        $filename = $this->patternNames[$name];
        $this->patterns[$name] = $this->loadPattern($filename);
    }

    /**
     * Загружает произвольные значения шаблона из указанного файла.
     * 
     * @param string $filename Имя файла шаблона.
     * 
     * @return array
     * 
     * @throws Exception\PatternNotLoadException Невозможно загрузить данные шаблона.
     */
    public function loadPattern(string $filename): array
    {
        return $this->loader->load($filename);
    }

    /**
     * Возвращает произвольные значения шаблона.
     * 
     * @param string $name Имя шаблона.
     * 
     * @return array|false Если значение `false`, шаблон произвольных значений 
     *     отсутствует. 
     */
    public function getPattern(string $name): false|array
    {
        return $this->patterns[$name] ?? false;
    }

    /**
     * Удаляет указанный шаблон произвольных значений.
     * 
     * @param string $name Имя шаблона произвольных значений.
     * 
     * @return bool Если значение `false`, шаблон произвольных значений отсутствует.
     */
    public function deletePattern(string $name): bool
    {
        if (isset($this->patterns[$name])) {
            unset($this->patterns[$name]);
            return true;
        }
        return false;
    }

    /**
     * Удаляет все произвольные значения шаблонов.
     * 
     * @see BaseGenerator::$patterns
     * 
     * @return void
     */
    public function clearPatterns(): void
    {
        $this->patterns = [];
    }
}
