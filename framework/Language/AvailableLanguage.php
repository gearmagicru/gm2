<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Language;

use Gm\Config\Config;

/**
 * Конфигуратор доступных (установленных) языков.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Language
 * @since 2.0
 */
class AvailableLanguage extends Config
{
    /**
     * {@inheritdoc}
     */
    protected bool $useSerialize = true;

    /**
     * Правила поиска языка.
     * 
     * @var array<string, mixed>
     */
    protected array $matching;

    /**
     * Инициализация правил поиска языка.
     * 
     * @return void
     */
    protected function initMatching(): void
    {
        foreach ($this->container as $name => &$params) {
            $this->matching['code.' . $params['code']]     = &$params; // code.570643
            $this->matching['slug.' . $params['slug']]     = &$params; // slug.ru
            $this->matching['tag.' . $params['tag']]       = &$params; // tag.ru-RU
            $this->matching['locale.' . $params['locale']] = &$params; // locale.ru_RU
        }
    }

    /**
     * Проверяет наличие языка по указанному параметру.
     * 
     * @param mixed $value Значение параметра.
     * @param string|null $parameter Название параметра. Если значение `null`, то проверит 
     *     наличие указанной локализации ($value).
     * 
     * @return bool
     */
    public function has(mixed $value, string $parameter = null): bool
    {
        if ($parameter === null) {
            return $this->get($value) !== null;
        }
        return $this->getBy($value, $parameter) !== null;
    }

    /**
     * Возвращает язык по указанному параметру.
     * 
     * @param mixed $value Значение параметра.
     * @param string $parameter Имя параметра.
     * 
     * @return null|array<string, mixed> Возвращает значение `null`, если язык с 
     *     указанными параметрами не найден.
     */
    public function getBy(mixed $value, string $parameter): ?array
    {
        if (!isset($this->matching)) {
            $this->initMatching();
        }
        return $this->matching[$parameter . '.' . $value] ?? null;
    }

    /**
     * Возвращает код язык по указанному значению параметра (код, тег).
     * 
     * @param mixed $value Значение параметра (код, тег).
     * 
     * @return null|array<string, mixed> Возвращает значение `null`, если язык с 
     *     указанными параметрами не найден.
     */
    public function getCodeBy(mixed $value): ?int
    {
        if (empty($value)) return null;
        // если указан код
        if (is_numeric($value)) $value;
        // если указан тег
        /** @var array|null $language */
        $language = $this->getBy($value, 'tag');
        return $language['code'] ?? null;
    }

    /**
     * Возвращает все языки по указанному параметру.
     * 
     * @param string $parameter
     * 
     * @return array<string, array<string, mixed>>
     */
    public function getAllBy(string $parameter): array
    {
        static $results = [];

        if (isset($results[$parameter])) {
            return $results[$parameter];
        }

        $result = [];
        foreach ($this->container as $key => $params) {
            $result[$params[$parameter]] = $params;
        }
        return $results[$parameter] = $result;
    }

    /**
     * Возвращает языки доступные для Backend.
     * 
     * В зависимости от параметра $details, возвращает:
     *    - `['ru_RU', 'en_GB', ...]` если $details = true;
     *    - `[['tag' => 'ru-RU', ...], ...]` если $details = false.
     * 
     * @param bool $details Если значение `true`, то включает полную информация о языке 
     *    из файла конфигурации языков, иначе имена локализаций ('ru_RU', 'en_GB', ...).
     * 
     * @return array<int, array|string>
     */
    public function forBackend(bool $details = false): array
    {
        $result = [];
        foreach ($this->container as $name => $params) {
            $backend = $params[BACKEND] ?? 1;
            if ($backend) {
                $result[] = $details ? $params : $name;
            }
        }
        return $result;
    }

    /**
     * Возвращает языки доступные для Frontend.
     * 
     * В зависимости от параметра $details, возвращает:
     *    - `['ru_RU', 'en_GB', ...]` если $details = true;
     *    - `[['tag' => 'ru-RU', ...], ...]` если $details = false.
     * 
     * @param bool $details Если значение `true`, то включает полную информация о языке 
     *    из файла конфигурации языков, иначе имена локализаций ('ru_RU', 'en_GB', ...).
     * 
     * @return array<int, array|string>
     */
    public function forFrontend(bool $details = false): array
    {
        $result = [];
        foreach ($this->contrainer as $name => $params) {
            $backend = $params[FRONTEND] ?? 1;
            if ($backend) {
                $result[] = $details ? $params : $name;
            }
        }
        return $result;
    }
}
