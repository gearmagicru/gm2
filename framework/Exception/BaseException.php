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
 * Базовый класс исключения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class BaseException extends \Exception implements ExceptionInterface
{
    /**
     * Формат HTTP-ответа.
     * 
     * Если формат указан, он будет установлен HTTP-ответу (даже если он уже имеет 
     * установленный формат). Формат устанавливается обработчиком ошибок {@see \Gm\ErrorHandler\ErrorHandler} 
     * во время рендера исключения {@see \Gm\ErrorHandler\WebErrorHandler::_renderException()}.
     * 
     * Значение должно соответствовать формату [FORMAT_RAW, FORMAT_HTML...] HTTP-ответа {@see \Gm\Http\Response}.
     * 
     * В зависимости от режима работы приложения, можно установить:
     * ```php
     * $responseFormat = GM_MODE_PRO ? 'raw' : null;
     * // или
     * $responseFormat = GM_MODE_PRO ? Response::FORMAT_RAW : null;
     * ```
     * что позволяет отображать отладочную информацию в режиме `development`.
     * 
     * @var null|string
     */
    public ?string $responseFormat = null;

    /**
     * Получает подготовленное сообщение исключения.
     * 
     * @return string Сообщение.
     */
    public function getDispatchMessage(): string
    {
        return '';
    }

    /**
     * Подготавливает и возвращает сообщение исключения для ответа.
     * 
     * Если исключение имеет сообщение {@see \Exception::getMessage()}, возвращает его. 
     * Иначе, подготовленное сообщение исключения {@see BaseException::getDispatchMessage()}.
     * 
     * @see BaseException::getDispatchMessage()
     * 
     * @return string Сообщение.
     */
    public function getDispatch(): string
    {
        if ($this->message) {
            return $this->message;
        }
        return $this->getDispatchMessage();
    }

    /**
     * Подготавливает и возвращает сообщение исключения для ответа без форматирования.
     * 
     * Сообщение исключает использование HTML.
     * 
     * Если исключение имеет сообщение {@see \Exception::getMessage()}, возвращает его. 
     * Иначе, подготовленное сообщение исключения {@see BaseException::getDispatchMessage()}.
     * 
     * @see BaseException::getDispatchMessage()
     * 
     * @return string Сообщение.
     */
    public function getPlainDispatch(): string
    {
        return $this->getDispatch();
    }

    /**
     * Возвращает имя исключения.
     * 
     * @return string Имя исключения.
     */
    public function getName(): string
    {
        return 'Exception';
    }
}
