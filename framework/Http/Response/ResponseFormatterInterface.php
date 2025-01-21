<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Http\Response;

/**
 * ResponseFormatterInterface определяет интерфейс Форматтера, необходимый для 
 * форматирования ответа перед его отправкой.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http\Response
 * @since 2.0
 */
interface ResponseFormatterInterface
{
    /**
     * Форматирует указанный ответ.
     * 
     * @param \Gm\Http\Response HTTP-ответ.
     * @param mixed $content Ответ который должен быть отформатирован.
     * 
     * @return mixed
     */
    public function format(\Gm\Http\Response $response, mixed $content): mixed;

    /**
     * Форматирует указанный ответ согласно брошенному исключению.
     * 
     * @param \Gm\Http\Response HTTP-ответ.
     * @param \Exception $exception Исключение.
     * @param mixed $content Ответ который должен быть отформатирован.
     * 
     * @return void
     */
    public function formatException(\Gm\Http\Response $response, $exception, mixed $content): void;

    /**
     * Подготовка к форматированию контента.
     * 
     * @param \Gm\Http\Response HTTP-ответ.
     * 
     * @return void
     */
    public function prepare(\Gm\Http\Response $response): void;
}
