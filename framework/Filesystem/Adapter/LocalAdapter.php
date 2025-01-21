<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Filesystem\Adapter;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\FilesystemAdapter as LeagueFsAdapter;

/**
 * Адаптер "Local" менеджера файловой системы Flysystem. Предназначен для 
 * выполнения операций с файлами и директориями.
 * 
 * Опции конфигурации адаптера:
 * - 'root', имя текущей директории;
 * - 'lock', флаг записи директории или файла;
 * - 'links', добавление линков;
 * - 'permissions', добавление прав доступа на файлы и директории.
 * 
 * @link https://github.com/thephpleague/flysystem-ziparchive
 * @link https://flysystem.thephpleague.com/v1/docs/adapter/zip-archive/
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filesystem\Adapter
 * @since 2.0
 */
class LocalAdapter extends AbstractAdapter
{
    /**
     * {@inheritdoc}
     */
    public function createLeagueFsAdapter(): ?LeagueFsAdapter
    {
        $links = ($this->options['links'] ?? null) === 'skip'
            ? LocalFilesystemAdapter::SKIP_LINKS
            : LocalFilesystemAdapter::DISALLOW_LINKS;

        return new LocalFilesystemAdapter(
            $this->options['root'],
            $this->options['lock'] ?? LOCK_EX,
            $links,
            $this->options['permissions'] ?? []
        );
    }
}
