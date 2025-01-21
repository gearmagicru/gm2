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
 * Исключение возникающие при отсутствии шаблона.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Exception
 * @since 2.0
 */
class TemplateNotFoundException extends NotFoundException
{
    /**
     * Формирование отчёта на основе исключения
     * 
     * @var bool
     */
    public bool $report = true;

    /**
     * Имя файла шаблона.
     * 
     * @var string
     */
    public string $filename = '';

    /**
     * {@inheritdoc}
     * 
     * @param string $filename Имя файла шаблона.
     */
    public function __construct(string $message = '', string $filename = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->filename = $filename;

        parent::__construct(200, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Could not render module, template with name "%s" not exists or not accessible', $this->filename ?: 'unknow');
    }
}
