<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Filesystem\Exception;

use Throwable;
use Gm\Exception\UserException;

/**
 * Исключение возникающие при изменении режима доступа к файлу.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Filesystem\Exception
 * @since 2.0
 */
class ChangeModeException extends UserException
{
    /**
     * Путь к файлу.
     * 
     * @var string
     */
    public string $filename = '';

    /**
     * Режим доступа.
     * 
     * @var int
     */
    public int $mode = 0;

    /**
     * Конструктор класса.
     * 
     * @param string $filename Путь к файлу (по умолчанию '').
     * @param string $mode Режим доступа (по умолчанию 0).
     * @param string $message Текст ошибки (по умолчанию '').
     * @param string $patternName Имя шаблона (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $filename = '', int $mode = 0, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->filename = $filename;
        $this->mode = $mode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Error trying to change mode for "%s" on "%s"', $this->filename, (string) $this->mode);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Change mode exception';
    }
}
