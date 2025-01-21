<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

/**
 * Исключение вызываемое при отсутствии файла.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class FileNotFoundException extends FileException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('File does not exist at path "%s".', $this->filename);
    }
}
