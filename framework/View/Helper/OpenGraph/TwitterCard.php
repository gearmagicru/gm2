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
 * Вспомогательный класс формирования "Open Graph" метатега для "Twitter Card" HTML-страницы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Helper\OpenGraph
 * @since 2.0
 */
class TwitterCard extends AbstractMeta
{
    /**
     * {@inheritdoc}
     */
    protected string $namePrefix = 'twitter:';

    /**
     * {@inheritdoc}
     */
    public string $comment = 'Twitter card data';

    /**
     * {@inheritdoc}
     */
    public function setCommon(array $names): static
    {
        $this->common = $names;
        $this
            ->setName('card', 'summary')
            ->setName('title', $names['title'] ?? '')
            ->setName('site', $names['site'] ?? '')
            ->setName('description', $names['description'] ?? '')
            ->setName('image', $names['image'] ?? '');

        if (isset($names['author']) && $names['author']) {
            $this->setName('creator', '@' . $names['author']);
        }
        return $this;
    }
}
