<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\MultiSite;

use Gm;
use Gm\Exception;
use Gm\Stdlib\Service;
use Gm\Config\Config;

/**
 * Мультисайт.
 * 
 * MultiSite - это служба приложения, доступ к которой можно получить через `Gm::$app->multiSite`.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\MultiSite
 * @since 2.0
 */
class MultiSite extends Service
{
    /**
     * {@inheritdoc}
     */
    protected bool $useUnifiedConfig = true;

    /**
     * Унифицированный конфигуратор приложения.
     *
     * @var Config
     */
    public Config $unifiedConfig;

    /**
     * Карта доменов сайтов.
     * 
     * @var Domains|array $domains
     */
    public Domains|array $domains = [];

    /**
     * Сайты.
     * 
     * @var Sites|array $domains
     */
    public Sites|array $items = [];

    /**
     * [Description for $site]
     *
     * @var array|null
     */
    public ?array $site = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        Gm::configure($this, $config, $this->useUnifiedConfig);

        if (!isset($this->unifiedConfig)) {
            $this->unifiedConfig = Gm::$app->unifiedConfig;
        }
        // если карта доменов указана в конфигурации
        if (is_array($this->domains)) {
            $this->domains = Domains::createInstance($this->domains);
        }
        // если атрибуты сайтов указаны в конфигурации
        if (is_array($this->items)) {
            $this->items = Sites::createInstance($this->items);
        }

        $this->init();
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectName(): string
    {
        return 'multiSite';
    }

    /**
     * [Description for initSite]
     *
     * @return array|null
     */
    protected function initSite(): ?array
    {
        /** @var array|null $site */
        return $this->site = $this->getByDomain($_SERVER['SERVER_NAME']);
    }

    /**
     * [Description for initSiteTheme]
     *
     * @param \Gm\Mvc\Application $app
     * @param array $site
     * 
     * @return \Gm\Theme\Theme
     */
    protected function initSiteTheme(\Gm\Mvc\Application $app, array $site): \Gm\Theme\Theme
    {
        if (IS_BACKEND) {
            $app->backendTheme->default = $site['backendTheme'];
            $app->theme = $app->backendTheme;
        } else
        if (IS_FRONTEND) {
            $app->frontendTheme->default = $site['frontendTheme'];
            $app->theme = $app->frontendTheme;
        }
        // устанавливаем тему по умолчанию
        $app->theme->set();
        return $app->theme;
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app): void
    {
        /** @var array|null $site */
        $site = $this->initSite();
        if ($site) {
            $this->initSiteTheme($app, $site);
            // если сайт не активен
            if (!$site['active']) {
                throw new Exception\PageUnavailableException();
            }
        }
    }

    /**
     * Проверяет, добавлены ли атрибуты сайт с указанным идентификатором.
     *
     * @param string $id Уникальный идентификатор сайта.
     * 
     * @return bool
     */
    public function hasSite(string $id): bool
    {
        return $this->items->has($id);
    }

    /**
     * Активирует или деактивирует работу указанного сайта.
     *
     * @param string $id Уникальный идентификатор сайта.
     * @param bool $active Активность сайта.
     * 
     * @return static
     */
    public function activate(string $id, bool $active): static
    {
        $this->items->activate($id, $active);
        return $this;
    }

    /**
     * Удаляет атрибуты сайта или сайтов по указанным идентификаторам.
     *
     * @param string|array $id Уникальный идентификатор(ы) сайта.
     * 
     * @return static
     */
    public function removeSite(string|array $id): static
    {
        $id = (array) $id;
        foreach ($id as $key) {
            $this->items->remove($key);
            $this->domains->removeBySiteId($key);
        }
        return $this;
    }

    /**
     * Добавляет атрибуты сайта.
     *
     * @param string $id Уникальный идентификатор сайта.
     * @param array|null $site Атрибуты сайта. Если значение `null`, то атрибуты 
     *     будут удалены.
     * 
     * @return static
     */
    public function setSite(string $id, ?array $site): static
    {
        $this->items->set($id, $site);
        $this->refreshDomains();
        return $this;
    }

    /**
     * Возвращает атрибуты сайта по указанному идентификатору.
     *
     * @param string $id Уникальный идентификатор сайта.
     * 
     * @return array|null Возвращает значение `null`, если атрибуты сайта не найдены.
     */
    public function getSite(string $id): ?array
    {
        return $this->items->get($id);
    }

    /**
     * Возвращает атрибуты сайта по указанному домену.
     *
     * @param string $domain Имя домена.
     * 
     * @return array|null Возвращает значение `null`, если атрибуты сайта не найдены.
     * 
     */
    public function getByDomain(string $domain): ?array
    {
        /** @var string|null $siteId */
        $siteId = $this->domains->get($domain);
        return $siteId ? $this->items->get($siteId) : null;
    }

    /**
     * Обновляет карту доменов сайтов.
     *
     * @return static
     */
    public function refreshDomains(): static
    {
        $map = $this->items->makeDomainsMap();
        $this->domains->setAll($map);
        return $this;
    }

    /**
     * Подсчитывает количество сайтов.
     * 
     * @see Collection::getCount()
     * 
     * @return int
     */
    public function count(): int
    {
        return $this->getCount();
    }

    /**
     * Подсчитывает количество сайтов.
     * 
     * @return int
     */
    public function getCount(): int
    {
        return $this->items->getCount();
    }

    /**
     * Удаляет атрибуты всех сайтов.
     * 
     * @see Collection::removeAll()
     * 
     * @return $this
     */
    public function clear(): static
    {
        $this->items->clear();
        $this->domains->clear();
        return $this;
    }

    /**
     * Сохраняет атрибуты сайтов.
     *
     * @return static
     */
    public function save(): static
    {
        $this->unifiedConfig->{$this->getObjectName()} = [
            'domains' => $this->domains->getAll(),
            'items'   => $this->items->getAll()
        ];
        $this->unifiedConfig->save();
        return $this;
    }
}
