<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Module\Exception;

use Throwable;
use Gm\Exception\NotFoundException;

/**
 *  Исключение возникающие при отсутствии доступа к контроллеру.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Module\Exception
 * @since 2.0
 */
class ControllerNotFoundException extends NotFoundException
{
    /**
     * В тому случаи если установлен режим "production", выводить шаблон страницы, 
     * иначе имя контроллера, который не существует.
     * 
     * @var string
     */
    public string $viewFile = GM_MODE_PRO ? '//errors/404' : '';

    /**
     * Имя контроллера.
     * 
     * @var string
     */
    public string $controllerName = '';

    /**
     * Конструктор класса.
     * 
     * @param string $message Текст ошибки (по умолчанию '').
     * @param string $controllerName Имя контроллера (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(string $message = '', string $controllerName = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->controllerName = $controllerName;

        parent::__construct(404, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Controller with name "%s" not exists', $this->controllerName ?: 'unknow');
    }
}
