<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Import\Parser;

use DOMDocument;
use SimpleXMLElement;

/**
 * DomParser класс разбора файла в формате XML с помощью DOMDocument.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Import\Parser
 * @since 2.0
 */
class DomParser extends AbstractParser
{
    /**
     * Загружает строку XML для разбора.
     * 
     * @see DomParser::parse()
     * @see DomParser::parsePackage()
     * 
     * @param string $str Строка для разбора.
     * 
     * @return SimpleXMLElement|null Возвращает значение `null` если была ошибка.
     */
    public function loadXML(string $str): ?SimpleXMLElement
    {
        $dom = new DOMDocument();
        /** @var DOMDocument|bool $result */
        $result = $dom->loadXML($str, LIBXML_NOCDATA);
        if ($result === false || isset( $dom->doctype)) {
            $this->addError('There was an error when reading this XML string');
            return null;
        }

        /** @var SimpleXMLElement|null $xml */
        $xml = simplexml_import_dom($dom);
        unset($dom);

        if ($xml === null) {
            $this->addError('There was an error when reading this XML string');
            return null;
        }
        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $str): ?array
    {
        /** @var SimpleXMLElement|null $xml */
        $xml = $this->loadXML($str);
        if ($xml === null) {
            return null;
        }

        $result = [
            'title'       => (string) $xml->title,
            'description' => (string) $xml->description,
            'language'    => (string) $xml->language,
            'version'     => (string) $xml->version,
            'created'     => (string) $xml->created,
            'clear'       => (int) $xml->clear > 0,
            'items'       => []
        ];
        foreach ($xml->xpath('/data/items/item') as $item) {
            $array = (array) $item;
            unset($array['comment']);
            $result['items'][] = $array;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function parsePackage(string $str): ?array
    {
        /** @var SimpleXMLElement|null $xml */
        $xml = $this->loadXML($str);
        if ($xml === null) {
            return null;
        }

        $result = [
            'title'       => (string) $xml->title,
            'description' => (string) $xml->description,
            'language'    => (string) $xml->language,
            'version'     => (string) $xml->version,
            'created'     => (string) $xml->created,
            'components'  => [],
            'files'       => []
        ];
        foreach ($xml->xpath('/package/components/component') as $component) {
            $children = $component->children();
            $result['components'][] = [
                'id'   => (string) $children->id,
                'type' => (string) $children->type,
                'file' => (string) $children->file,
                'cls'  => (string) $children->cls
            ];
        }
        foreach ($xml->xpath('/package/files/file') as $component) {
            $children = $component->children();
            $result['files'][] = [
                'name' => (string) $children->name,
                'path' => (string) $children->path
            ];
        }
        return $result;
    }
}
