<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View\Exception;

use Throwable;
use Gm\Exception\NotFoundException;

/**
 * Исключение возникающие при отсутствии визуализатора (renderer).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Exception
 * @since 2.0
 */
class RenderNotFoundException extends NotFoundException
{
    /**
     * Имя визуализатора.
     * 
     * @var string
     */
    public string $renderName = '';

    /**
     * {@inheritdoc}
     * 
     * @param string $renderName Имя визуализатора.
     */
    public function __construct(string $message = '', string $renderName = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->renderName = $renderName;

        parent::__construct(200, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Render "%s" not found', $this->renderName ?: 'unknow');
    }
}
