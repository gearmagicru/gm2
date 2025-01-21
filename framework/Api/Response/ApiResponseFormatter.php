<?php
/**
 * Gm Panel
 * 
 * @link https://gearmagic.ru/gpanel/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/gpanel/license/
 */

namespace Gm\Api\Response;

use Gm\Exception\BaseException;
use Gm\Http\Response\JsonResponseFormatter;

/**
 * Класс Форматтера для форматирования HTTP-ответа (результат выполнения API) в формат JSON.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Api\Response
 * @since 2.0
 */
class ApiResponseFormatter extends JsonResponseFormatter
{
    /**
     * Метаданные формата JSON.
     * 
     * @var ApiMetaData
     */
    public ApiMetaData $meta;

    /**
     * Конструктор класса.
     * 
     * @param \Gm\Http\Response $response HTTP-ответ.
     * 
     * @return void
     */
    public function __construct(\Gm\Http\Response $response)
    {
        parent::__construct($response);

       $this->meta = new ApiMetadata();
    }

   /**
     * {@inheritdoc}
     */
    public function format(\Gm\Http\Response $response, mixed $content): mixed
    {
        /** 
         * не будем использовать $content самого Response,
         * нужен чистый ответ 
         * $this->meta->content($content); 
         */
        $text = $this->meta->message;
        // добавление к контенту исключений
        if ($response->exceptionContent) {
            $this->meta->success = false;
            $text .= $response->exceptionContent;
        }
        $this->meta->message = $text;
        $result = $this->meta->toString();
        if ($result === false)
            return json_last_error_msg();
        else
            return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function formatException(\Gm\Http\Response $response, $exception, mixed $content): void
    {
        // Если исключение поймано через обработчик ошибок {\Gm\ErrorHandler\WebErrorHandler} и
        // $content не был указан перед вызовом исключения, то он будет содержать сообщение об ошибке, 
        // полученное через getPlainDispatch() исключения.
    
        // удостоверимся, что это наше исключение
        if ($exception instanceof BaseException)
            $message = $exception->getPlainDispatch();
        else 
            $message = $exception->getMessage();
        // если режим "development"
        if (GM_MODE_DEV)
            $this->meta->error($message);
        // если режим "production"
        else
            $this->meta->error('Server Error');
    }
}
