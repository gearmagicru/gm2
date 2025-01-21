<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

use Throwable;

/**
 * Исключение возникающие при вызове недействительных аргументов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class XMLTagException extends UserException
{
    /**
     * Имя тега.
     * 
     * @var string
     */
    protected string $tagName;

    /**
     * Конструктор класса.
     * 
     * @param string $tagName Имя тега.
     * @param string $message Текст ошибки  (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $tagName, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->tagName = $tagName;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Invalid tag name or tag "%s" does not exist.', $this->tagName);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'XML Tag exception';
    }
}
