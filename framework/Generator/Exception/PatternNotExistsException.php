<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator\Exception;

use Throwable;
use Gm\Exception\NotDefinedException;

/**
 * Исключение возникающие при отсутствии вызываемого шаблона.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator\Exception
 * @since 2.0
 */
class PatternNotExistsException extends NotDefinedException
{
    /**
     * Имя шаблона.
     * 
     * @var string
     */
    public string $patternName = '';

    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки (по умолчанию '').
     * @param string $patternName Имя шаблона (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $message = '', string $patternName = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->patternName = $patternName;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Could not load pattern, pattern "%s" not exists', $this->patternName ?: 'unknow');
    }
}
