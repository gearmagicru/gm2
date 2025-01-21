<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\ModuleManager;

use Gm;

/**
 * Генератор.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\ModuleManager
 * @since 2.0
 */
class Generator
{
    public $apiPath = 'D:\OSPanel\domains\api.gm';

    /**
     * Get categories
     *
     * @return array
     */
    public function getCategories(): array
    {
        return [
            'gm.frontend.site' => 'request',
            'gm.frontend.api' => 'request',
            'gm.backend.signin' => 'authorization',
            'gm.backend.signout' => 'authorization',
            'gm.backend.task' => 'request',
            'gm.backend.workspace' => 'interface',
            'gm.backend.audit.log' => 'logging',
            'gm.backend.config' => 'configurations',
            'gm.backend.languages' => 'localization',
            'gm.backend.guide' => 'development',
            'gm.backend.recovery' => 'authorization',
            'gm.backend.error.report' => 'logging',
            'gm.backend.users' => 'users',
            'gm.backend.user.profiles' => 'users',
            'gm.backend.user.roles' => 'users',
            'gm.backend.debug.toolbar' => 'development',
            'gm.backend.import' => 'import',
            'gm.backend.templates' => 'editors',
            'gm.backend.dashboard' => 'interface',
            'gm.backend.shortcuts' => 'interface',
            'gm.crm.classifiers' => 'classifiers',
            'gm.crm.references' => 'references',
            'gm.backend.partitionbar' => 'interface',
            'gm.backend.traybar' => 'interface',
            'gm.backend.menu' => 'interface',
            'gm.backend.articles' => 'articles',
            'gm.backend.article.categories' => 'articles',
            'gm.crm.persons' => 'references',
            'gm.crm.contracts' => 'references',
            'gm.crm.contractors' => 'references',
            'gm.crm.deals' => 'references',
            'gm.backend.generator' => 'development',
            'gm.backend.marketplace' => 'installers',
            //
            'gm.config.autorun' => 'configurations',
            'gm.classifiers.banks' => 'classifiers',
            'gm.references.banks' => 'references',
            'gm.config.ipwhitelist' => 'security',
            'gm.classifiers.currency' => 'classifiers',
            'gm.references.currency' => 'references',
            'gm.config.version' => 'configurations',
            'gm.classifiers.packaging' => 'classifiers',
            'gm.classifiers.vehicles' => 'classifiers',
            'gm.classifiers.contact.types' => 'classifiers',
            'gm.references.trucs' => 'references',
            'gm.config.datetime' => 'configurations',
            'gm.classifiers.units' => 'classifiers',
            'gm.config.upload' => 'configurations',
            'gm.import.files' => 'import',
            'gm.import.leads' => 'import',
            'gm.classifiers.popinfo' => 'classifiers',
            'gm.config.page' => 'articles',
            'gm.marketplace.catalog' => 'installers',
            'gm.classifiers.contacts' => 'classifiers',
            'gm.config.cache' => 'configurations',
            'gm.config.logger' => 'logging',
            'gm.config.url' => 'configurations',
            'gm.marketplace.wmanager' => 'installers',
            'gm.marketplace.mmanager' => 'installers',
            'gm.marketplace.emanager' => 'installers',
            'gm.config.defense' => 'security',
            'gm.config.modules' => 'installers',
            'gm.marketplace.updates' => 'installers',
            'gm.classifiers.poffices' => 'classifiers',
            'gm.references.poffices' => 'references',
            'gm.classifiers.legalforms' => 'classifiers',
            'gm.import.desk' => 'import',
            'gm.classifiers.desk' => 'classifiers',
            'gm.config.desk' => 'configurations',
            'gm.marketplace.desk' => 'installers',
            'gm.references.desk' => 'references',
            'gm.config.mail' => 'configurations',
            'gm.classifiers.positions' => 'classifiers',
            'gm.references.positions' => 'references',
            'gm.config.wspace' => 'interface',
            'gm.config.timezone' => 'configurations',
            'gm.config.session' => 'configurations',
            'gm.config.services' => 'development',
            'gm.config.ipblocklist' => 'security',
            'gm.classifiers.countries' => 'classifiers',
            'gm.references.countries' => 'references',
            'gm.marketplace.minstaller' => 'installers',
            'gm.config.ipblacklist' => 'security',
            //
            'gm.site.control' => 'editions',
            'gm.panel.control' => 'editions',
            'gm.forwarder.control' => 'editions',
            'gm.themes.green' => 'themes',
        ];
    }

    /**
     * Get editons
     *
     * @return array
     */
    public function getComponentEditions(): array
    {
        return [
            '*' => ['Site control', 'Forwarder control'],
            //
            'gm.frontend.site' => ['Site control'],
            'gm.frontend.api' => ['Site control'],
            'gm.backend.articles' => ['Site control'],
            'gm.backend.article.categories' => ['Site control'],
            'gm.config.page' => ['Site control'],
            //
            'gm.backend.import' => ['Forwarder control'],
            'gm.crm.classifiers' => ['Forwarder control'],
            'gm.crm.references' => ['Forwarder control'],
            'gm.crm.persons' => ['Forwarder control'],
            'gm.crm.contracts' => ['Forwarder control'],
            'gm.crm.contractors' => ['Forwarder control'],
            'gm.crm.deals' => ['Forwarder control'],
            'gm.classifiers.banks' => ['Forwarder control'],
            'gm.references.banks' => ['Forwarder control'],
            'gm.classifiers.currency' => ['Forwarder control'],
            'gm.references.currency' => ['Forwarder control'],
            'gm.classifiers.packaging' => ['Forwarder control'],
            'gm.classifiers.vehicles' => ['Forwarder control'],
            'gm.classifiers.contact.types' => ['Forwarder control'],
            'gm.references.trucs' => ['Forwarder control'],
            'gm.classifiers.units' => ['Forwarder control'],
            'gm.import.files' => ['Forwarder control'],
            'gm.import.leads' => ['Forwarder control'],
            'gm.classifiers.popinfo' => ['Forwarder control'],
            'gm.classifiers.contacts' => ['Forwarder control'],
            'gm.classifiers.poffices' => ['Forwarder control'],
            'gm.references.poffices' => ['Forwarder control'],
            'gm.classifiers.legalforms' => ['Forwarder control'],
            'gm.import.desk' => ['Forwarder control'],
            'gm.classifiers.desk' => ['Forwarder control'],
            'gm.references.desk' => ['Forwarder control'],
            'gm.classifiers.positions' => ['Forwarder control'],
            'gm.references.positions' => ['Forwarder control'],
            'gm.classifiers.countries' => ['Forwarder control'],
            'gm.references.countries' => ['Forwarder control'],
            //
            'gm.site.control' => [],
            'gm.panel.control' => [],
            'gm.forwarder.control' => []
        ];
    }

    protected function collectExtensions($extensions): string
    {
        if (empty($extensions)) return '[]';

        $result = [];
        foreach ($extensions as $item) {
            $result[] = '"' . $item['id'] . '"';
        }
        return '[' . implode(', ', $result) . ']';
    }

    /**
     * Get modules
     *
     * @return array
     */
    public function getModules(): array
    {
        $catgories = $this->getCategories();
        $editions  = $this->getComponentEditions();
        $registry  = Gm::$app->modules->getRegistry();
        $rows      = $registry->getListInfo(true, false, 'rowId', ['icon' => true, 'version' => true]);

        $repositoryPath = $this->apiPath . '\repository';
        $result = [];
        foreach ($rows as $index => $row) {
            $id  = $row['id'];
            $_id = str_replace('.', '-', $id);

            // путь к модулю репозитория
            $path = $repositoryPath . '\\' . $_id;
            $price = $row['price'] ?? 'free';
            if ($price !== 'free') {
                $price = number_format($price, 2, ',', ' ') . ' руб.';
            }
            $enabled = (bool) ($row['enabled'] ?? true);
            $system = (bool) ($row['lock'] ?? false);

            // редакция
            if (isset($editions[$id]))
                $edition = $editions[$id];
            else
            if (isset($editions['*']))
                $edition = $editions['*'];

            $result[] = [
                'id'          => $id,
                'folder'      => $_id,
                'use'         => $row['use'] ?? '',
                'type'        => 'module',
                'system'      => $system ? 'true' : 'false',
                'enabled'     => $enabled,
                'category'    => $catgories[$id] ?? '',
                'edition'     => $edition,
                'extensions'  => $this->collectExtensions($row['extensions'] ?? ''),
                'name'        => $row['name'] ?? '',
                'description' => $row['description'] ?? '',
                'version'     => $row['version']['version'] ?? '1.0',
                'date'        => $row['version']['versionDate'] ?? '',
                'author'      => 'GearMagic',
                'license'     => $row['version']['license'] ?? '',
                'copyright'   => $row['version']['copyright'] ?? '',
                'price'       => $price,
                'repository'  => [
                    'path'        => $path,
                    'assetsPath'  => $path . '\assets',
                    'guidePath'   => $path . '\guide',
                    'infoPath'    => $path . '\info',
                    'infoFile'    => $path . '\info.json',
                    'guideFile'   => $path . '\guide.json',
                    'indexFile'   => $path . '\guide\index.html',
                    'descFile'    => $path . '\info\description.html',
                    'installFile' => $path . '\info\install.html',
                    'originalPath' => Gm::$app->modulePath . $row['path'],
                ]
            ];
        }
        return $result;
    }

    /**
     * Get extensions
     *
     * @return array
     */
    public function getExtensions(): array
    {
        $catgories = $this->getCategories();
        $editions  = $this->getComponentEditions();
        $registry  = Gm::$app->extensions->getRegistry();
        $mregistry = Gm::$app->modules->getRegistry();
        $rows      = $registry->getListInfo(true, false, 'rowId', ['icon' => true, 'version' => true]);

        $repositoryPath = $this->apiPath . '\repository';
        $result = [];
        foreach ($rows as $index => $row) {
            $id  = $row['id'];
            $_id = str_replace('.', '-', $id);

            $moduleId = $mregistry->getAtMap($row['moduleRowId'] ?? 0, 'id');

            // путь к расширению репозитория
            $path = $repositoryPath . '\\' . $_id;
            $price = $row['price'] ?? 'free';
            if ($price !== 'free') {
                $price = number_format($price, 2, ',', ' ') . ' руб.';
            }
            $enabled = (bool) ($row['enabled'] ?? true);
            $system = (bool) ($row['lock'] ?? false);

            // редакция
            if (isset($editions[$id]))
                $edition = $editions[$id];
            else
            if (isset($editions['*']))
                $edition = $editions['*'];

            $result[] = [
                'id'          => $id,
                'folder'      => $_id,
                'use'         => $row['use'] ?? '',
                'type'        => 'extension',
                'system'      => $system ? 'true' : 'false',
                'enabled'     => $enabled,
                'category'    => $catgories[$id] ?? '',
                'edition'     => $edition,
                'module'      => $moduleId ?: '',
                'enabled'     => $enabled,
                'name'        => $row['name'] ?? '',
                'description' => $row['description'] ?? '',
                'version'     => $row['version']['version'] ?? '1.0',
                'date'        => $row['version']['versionDate'] ?? '',
                'author'      => 'GearMagic',
                'license'     => $row['version']['license'] ?? '',
                'copyright'   => $row['version']['copyright'] ?? '',
                'price'       => $price,
                'repository'  => [
                    'path'        => $path,
                    'assetsPath'  => $path . '\assets',
                    'guidePath'   => $path . '\guide',
                    'infoPath'    => $path . '\info',
                    'infoFile'    => $path . '\info.json',
                    'guideFile'   => $path . '\guide.json',
                    'indexFile'   => $path . '\guide\index.html',
                    'descFile'    => $path . '\info\description.html',
                    'installFile' => $path . '\info\install.html',
                    'originalPath' => Gm::$app->modulePath . $row['path'],
                ]
            ];
        }
        return $result;
    }

    /**
     * Get widgets
     *
     * @return array
     */
    public function getWidgets(): array
    {
        return [];
    }

    /**
     * Get other
     *
     * @return array
     */
    public function getOther(): array
    {
        $rows = [
            [
                'id' => 'gm.site.control',
                'use' => '',
                'category' => 'editions',
                'type' => 'edition',
                'name' => 'Управление сайтом',
                'description' => 'Система управления контентом сайта',
                'version' => '1.0',
                'enabled' => false
            ],
            [
                'id' => 'gm.forwarder.control',
                'use' => '',
                'category' => 'editions',
                'type' => 'edition',
                'name' => 'Управление экспедитором',
                'description' => 'Система управления взаимоотношениями с перевозчиками и экспедиторами',
                'price'       => '25000',
                'version' => '1.0',
                'enabled' => false
            ],
            [
                'id' => 'gm.panel.control',
                'use' => '',
                'category' => 'editions',
                'type' => 'panel',
                'name' => 'Панель управления',
                'description' => 'Базовая Панель управления контентом',
                'version' => '1.0',
                'enabled' => false
            ],
        ];

        $catgories = $this->getCategories();
        $editions  = $this->getComponentEditions();

        $repositoryPath = $this->apiPath . '\repository';
        $result = [];
        foreach ($rows as $index => $row) {
            $id  = $row['id'];
            $_id = str_replace('.', '-', $id);

            // путь к расширению репозитория
            $path = $repositoryPath . '\\' . $_id;
            $price = $row['price'] ?? 'free';
            if ($price !== 'free') {
                $price = number_format($price, 0, ',', ' ') . ' руб.';
            }
            $enabled = (bool) ($row['enabled'] ?? true);

            // редакция
            if (isset($editions[$id]))
                $edition = $editions[$id];
            else
            if (isset($editions['*']))
                $edition = $editions['*'];

            $result[] = [
                'id'          => $id,
                'folder'      => $_id,
                'use'         => $row['use'],
                'type'        => $row['type'],
                'system'      => 'false',
                'enabled'     => $enabled,
                'category'    => $catgories[$id] ?? '',
                'edition'     => $edition,
                'name'        => $row['name'],
                'description' => $row['description'],
                'version'     => $row['version'],
                'date'        => '01-01-2015',
                'author'      => 'GearMagic',
                'license'     => 'GNU General Public License, version 2.0 or later',
                'copyright'   => 'Copyright (c) 2015 Веб-студия GearMagic',
                'price'       => $price,
                'repository'  => [
                    'path'        => $path,
                    'assetsPath'  => $path . '\assets',
                    'guidePath'   => $path . '\guide',
                    'infoPath'    => $path . '\info',
                    'infoFile'    => $path . '\info.json',
                    'guideFile'   => $path . '\guide.json',
                    'indexFile'   => $path . '\guide\index.html',
                    'descFile'    => $path . '\info\description.html',
                    'installFile' => $path . '\info\install.html'
                ]
            ];
        }
        Gm::dump($result);
        return $result;
    }

    /**
     * Save Solutions
     *
     * @param string $filename
     * 
     * @return void
     */
    public function saveSolutions($text)
    {
        file_put_contents($this->apiPath . '\config\solutions.json', $text);
    }

    /**
     * Save Info
     *
     * @param string $filename
     * @param array $row
     * 
     * @return void
     */
    public function saveInfo(string $filename, array $row)
    {
        if (isset($row['module'])) {
            $moduleStr = "    \"module\": \"{$row['module']}\",\n";
        } else
            $moduleStr = '';

        if (isset($row['extensions'])) {
            $extensionsStr = "    \"extensions\": \"{$row['extensions']}\",\n";
        } else
            $extensionsStr = '';

        // редакция
        $edition = $row['edition'] ?? [];
        if ($edition) {
            $result = [];
            foreach ($edition as $item) {
                $result[] = '"' . $item . '"';
            }
            $edition = '[' . implode(',', $result) . ']';
        }

        $enabled = $row['enabled'] ?? true;
        $info = 
            "{\n" .
            "    \"id\": \"{$row['id']}\",\n" . 
            "    \"folder\": \"{$row['folder']}\",\n" . 
            "    \"use\": \"{$row['use']}\",\n" . 
            "    \"type\": \"{$row['type']}\",\n" .
            "    \"system\": {$row['system']},\n" .
            "    \"category\": \"{$row['category']}\",\n" .
            "    \"edition\": $edition,\n" .
            $moduleStr .
            $extensionsStr . 
            "    \"name\": \"{$row['name']}\",\n" . 
            "    \"description\": \"{$row['description']}\",\n" . 
            "    \"version\": \"{$row['version']}\",\n" . 
            "    \"date\": \"{$row['date']}\",\n" . 
            "    \"author\": \"{$row['author']}\",\n" . 
            "    \"price\": \"{$row['price']}\",\n" . 
            "    \"license\": \"{$row['license']}\",\n" . 
            "    \"copyright\": \"{$row['copyright']}\",\n" .
            "    \"enabled\": " . ($enabled ? 'true' : 'false') . "\n" .
        "}";
        file_put_contents($filename, $info);
    }

    /**
     * Save Guide
     *
     * @param string $filename
     * 
     * @return void
     */
    public function saveGuide(string $filename)
    {
        $guide = 
        "{\n" .
            "    \"item-1\": \"Пункт 1\",\n" . 
            "    \"item-2\": \"Пункт 2\",\n" . 
            "    \"item-3\": \"Пункт 3\"\n" . 
        "}";
        file_put_contents($filename, $guide);
    }

    /**
     * Save Guide Index
     *
     * @param string $filename
     * @param array $row
     * 
     * @return void
     */
    public function saveGuideIndex(string $filename, array $row)
    {
        $text = '<h2>' . $row['name'] . '</h2>' . "\n" .
        '<p>' . $row['description'] . '</p>' . "\n";
        file_put_contents($filename, $text);
    }

    /**
     * Save Install
     *
     * @param string $filename
     * @param array $row
     * 
     * @return void
     */
    public function saveInstall(string $filename, array $row)
    {
        $text = '<p>Для установки "' . $row['name'] . '" необходимо...</p>';
        file_put_contents($filename, $text);
    }

    /**
     * Save Description
     *
     * @param string $filename
     * @param array $row
     * 
     * @return void
     */
    public function saveDescription(string $filename, array $row)
    {
        $text = '<p>' . $row['description'] . '</p>';
        file_put_contents($filename, $text);
    }

    /**
     * Run
     *
     * @return void
     */
    public function run()
    {
        $modules    = $this->getModules();
        $extensions = $this->getExtensions();
        $widgets    = $this->getWidgets();
        $other      = $this->getOther();
        $rows = array_merge($modules, $extensions, $widgets, $other);

        /** */
        $solutions = [];
        foreach ($rows as $row) {
            // редакция
            $edition = $row['edition'] ?? [];
            if ($edition) {
                $result = [];
                foreach ($edition as $item) {
                    $result[] = '"' . $item . '"';
                }
                $edition = '[' . implode(',', $result) . ']';
            } else
                $edition = '[]';
            // доступность
            $enabled = $row['enabled'] ?? true;

            $solutions[] = 
                "{\n" .
                    "    \"id\": \"{$row['id']}\",\n" . 
                    "    \"folder\": \"{$row['folder']}\",\n" . 
                    "    \"use\": \"{$row['use']}\",\n" . 
                    "    \"type\": \"{$row['type']}\",\n" . 
                    "    \"system\": {$row['system']},\n" .
                    "    \"category\": \"{$row['category']}\",\n" .
                    "    \"edition\": $edition,\n" .
                    "    \"version\": \"{$row['version']}\",\n" . 
                    "    \"date\": \"{$row['date']}\",\n" . 
                    "    \"author\": \"{$row['author']}\",\n" . 
                    "    \"price\": \"{$row['price']}\",\n" . 
                    "    \"name\": \"{$row['name']}\",\n" . 
                    "    \"description\": \"{$row['description']}\",\n" . 
                    "    \"enabled\": " . ($enabled ? 'true' : 'false') . "\n" .
                "}";
        }
        $solutionsJson = '[' . implode(",\n", $solutions) . ']';
        $this->saveSolutions($solutionsJson);

        /**/
        foreach ($rows as $row) {
            mkdir($row['repository']['path']);
            mkdir($row['repository']['assetsPath']);
            mkdir($row['repository']['guidePath']);
            mkdir($row['repository']['infoPath']);

            if (isset($row['repository']['originalPath'])) {
                copy($row['repository']['originalPath'] . '\assets\images\icon.svg', $row['repository']['assetsPath'] . '\icon.svg');
                copy($row['repository']['originalPath'] . '\assets\images\icon_small.svg', $row['repository']['assetsPath'] . '\icon_small.svg');
            }

            $this->saveInstall($row['repository']['installFile'], $row);
            $this->saveDescription($row['repository']['descFile'], $row);
            $this->saveGuideIndex($row['repository']['indexFile'], $row);
            $this->saveGuide($row['repository']['guideFile']);
            $this->saveInfo($row['repository']['infoFile'], $row);
        }
    }
}
