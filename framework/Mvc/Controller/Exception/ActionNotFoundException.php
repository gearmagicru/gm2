<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Controller\Exception;

use Throwable;
use Gm\Exception\NotFoundException;

/**
 * Исключение вызванное при отсутствии действия в контроллере.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Controller\Exception
 * @since 2.0
 */
class ActionNotFoundException extends NotFoundException
{
    /**
     * В тому случаи если установлен режим "production", выводить шаблон страницы, 
     * иначе имя действия контроллера, которого нет.
     * 
     * @var string
     */
    public string $viewFile = GM_MODE_PRO ? '//errors/404' : '';

    /**
     * Имя действия контроллера.
     * 
     * @var string
     */
    public string $actionName = '';

    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки  (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $message = '', string $actionName = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->actionName = $actionName;

        parent::__construct(404, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Action at controller "%s" not exists', $this->actionName ?: 'unknow');
    }
}
