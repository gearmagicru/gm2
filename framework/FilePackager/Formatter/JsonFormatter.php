<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\FilePackager\Formatter;

use Gm\Helper\Json;

/**
 * Форматирование свойств пакета файлов в формат JSON.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\FilePackager\Formatter
 * @since 2.0
 */
class JsonFormatter extends AbstractFormatter
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $str): ?array
    {
        $properties = Json::decode($str);
        if ($error = Json::error()) {
            // Невозможно получить данные из файла пакета
            $this->addError('Can\'t to get data from package file' . (GM_DEBUG ? " ($error)" : ''));
            return null;
        }
        return $this->applyIf($properties);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return Json::encode($this->applyIf($this->properties));
    }
}
