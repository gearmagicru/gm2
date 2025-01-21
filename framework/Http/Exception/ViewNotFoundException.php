<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Http\Exception;

use Throwable;
use Gm\Exception;

/**
 * Исключение возникающие при отсутствии шаблона представления.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http\Exception
 * @since 2.0
 */
class ViewNotFoundException extends Exception\UserException
{
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
    public function __construct(string $filename = '', string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->filename = $filename;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Unable to load template, file "%s" not exists.', $this->filename);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'View not found';
    }
}
