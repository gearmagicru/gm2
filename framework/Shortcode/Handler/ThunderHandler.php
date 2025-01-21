<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Shortcode\Handler;

use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Parser\RegularParser;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;

/**
 * Thunder обработчик шорткодов.
 * 
 * Advanced shortcode (BBCode) parser and engine for PHP http://kowalczyk.cc
 * 
 * @see https://github.com/thunderer/Shortcode
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Shortcode\Handler
 * @since 2.0
 */
class ThunderHandler extends AbstractHandler
{
    /**
     * Контейнер.
     *
     * @var HandlerContainer
     */
    protected HandlerContainer $container;

    /**
     * {@inheritdoc}
     */
    public function __construct($manager, $shortcodes)
    {
        $this->shortcodes = $shortcodes;
        $this->manager = $manager;
        $this->container = new HandlerContainer();
        $this->registerShortcodes($shortcodes);
        $this->createProcessor();
    }

    /**
     * {@inheritdoc}
     */
    protected function createProcessor(): static
    {
        $this->processor = new Processor(new RegularParser(), $this->container);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerShortcodes(array $shortcodes): static
    {
        /** @var ShortcodeManager $manager */
        $manager = $this->manager;
        foreach ($shortcodes as $name => $options) {
            $this->container->add($name, function(ShortcodeInterface $s) use ($manager) {
                return $manager->getContent($name, $s->getParameters());
            });
        }
       $this->defaultShortcodes();
       return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function process(string $text): string
    {
        return $this->processor->process($text);
    }
}
