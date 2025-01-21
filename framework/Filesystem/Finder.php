<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Filesystem;

use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * Класс-обвертка для SymfonyFinder, позволяющий создавать правила для поиска файлов и 
 * каталогов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filesystem
 * @since 2.0
 */
class Finder extends SymfonyFinder
{
    /**
     * Указывает на то, что поиск был осуществлён.
     * 
     * @var bool
     */
    public bool $searched = false;

    /**
     * {@inheritdoc}
     */
    public function in($dirs)
    {
        $this->searched = true;

        return parent::in($dirs);
    }

    /**
     * {@inheritdoc}
     */
    public function append(iterable $iterator)
    {
        $this->searched = true;

        return parent::in($iterator);
    }
}
