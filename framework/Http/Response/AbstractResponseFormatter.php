<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Http\Response;

use Gm\Http\Response;

/**
 * Абстрактный класс Форматтера, необходимый для форматирования ответа перед его 
 * отправкой.
 * 
 * - подготавливает контент к форматированию в событии {@see Response::EVENT_BEFORE_SEND} 
 * HTTP-ответа;
 * - форматирует указанный ответ согласно брошенному исключению для события {@see Response::EVENT_SET_EXCEPTION} 
 * HTTP-ответа.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http\Response
 * @since 2.0
 */
abstract class AbstractResponseFormatter implements ResponseFormatterInterface
{
    /**
     * Конструктор класса.
     * 
     * @param \Gm\Http\Response $response HTTP-ответ.
     * 
     * @return void
     */
    public function __construct(\Gm\Http\Response $response)
    {
        $response
            ->on(Response::EVENT_BEFORE_SEND, [$this, 'prepare'])
            ->on(Response::EVENT_SET_EXCEPTION, [$this, 'formatException']);
    }

    /**
     * {@inheritdoc}
     */
    public function format(\Gm\Http\Response $response, mixed $content): mixed
    {
    }

    /**
     * {@inheritdoc}
     */
    public function formatException(\Gm\Http\Response $response, $exception, mixed $content): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function prepare(\Gm\Http\Response $response): void
    {
    }
}
