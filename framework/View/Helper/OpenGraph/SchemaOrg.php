<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View\Helper\OpenGraph;

use Gm\View\Helper\AbstractMeta;

/**
 * Вспомогательный класс формирования микроразметки "SchemaOrg" HTML-страницы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Helper\OpenGraph
 * @since 2.0
 */
class SchemaOrg extends AbstractMeta
{
    /**
     * {@inheritdoc}
     */
    public string $comment = 'Schema.org markup';

    /**
     * {@inheritdoc}
     */
    public function setCommon(array $names): static
    {
        $this->common = $names;
        $this
            ->set('itemprop', 'name', $names['title'] ?? '')
            ->set('itemprop', 'description', $names['description'] ?? '')
            ->set('itemprop', 'image', $names['image'] ?? '');
        return $this;
    }

    /**
     * Возвращение схемы объектов Open Graph
     *
     * @return array
     */
    public function getHtmlAttributes(): array
    {
        return [
            'itemscope' => '',
            'itemtype'  => 'http://schema.org/Article'
        ];
    }
}
