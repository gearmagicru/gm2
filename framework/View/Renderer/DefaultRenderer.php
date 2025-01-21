<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View\Renderer;

/**
 * Визуализатор по умолчанию.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Renderer
 * @since 2.0
 */
class DefaultRenderer extends AbstractRenderer
{
    /**
     * Вывод данных в JSON-представлении.
     * 
     * @param mixed $variables Данные для вывода.
     * 
     * @return void
     */
    public function render(mixed $variables): void
    {
        echo json_encode($variables);
    }
}
