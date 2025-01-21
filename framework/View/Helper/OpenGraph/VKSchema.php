<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View\Helper\OpenGraph;

use Gm\Stdlib\StaticClass;
use Gm\View\Helper\AbstractMeta;

/**
 * Вспомогательный класс формирования микроразметки "VK" HTML-страницы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Helper\OpenGraph
 * @since 2.0
 */
class VKSchema extends AbstractMeta
{
    /**
     * {@inheritdoc}
     */
    protected string $namePrefix = 'vk:';

    /**
     * {@inheritdoc}
     */
    public string $comment = 'VK data';

    /**
     * {@inheritdoc}
     */
    public function setCommon(array $names): static
    {
        $this->common = $names;
        $this
            ->setName('image', $names['image'] ?? '');
        return $this;
    }
}
