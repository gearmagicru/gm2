<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

/**
 * Интерфейс исключения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
interface ExceptionInterface
{
    /**
     * Получает подготовленное сообщение исключения.
     * 
     * @return string Сообщение.
     */
    public function getDispatchMessage(): string;

    /**
     * Подготавливает и возвращает сообщение исключения для ответа.
     * 
     * Если исключение имеет сообщение {@see \Exception::getMessage()}, возвращает его. 
     * Иначе, подготовленное сообщение исключения {@see ExceptionInterface::getDispatchMessage()}.
     * 
     * @see ExceptionInterface::getDispatchMessage()
     * 
     * @return string Сообщение.
     */
    public function getDispatch(): string;

    /**
     * Подготавливает и возвращает сообщение исключения для ответа без форматирования.
     * 
     * Сообщение исключает использование HTML.
     * 
     * Если исключение имеет сообщение {@see \Exception::getMessage()}, возвращает его. 
     * Иначе, подготовленное сообщение исключения {@see ExceptionInterface::getDispatchMessage()}.
     * 
     * @see ExceptionInterface::getDispatchMessage()
     * 
     * @return string Сообщение.
     */
    public function getPlainDispatch(): string;

    /**
     * Возвращает имя исключения.
     * 
     * @return string Имя исключения.
     */
    public function getName(): string;
}
