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
 * Класс Форматтера для форматирования HTTP-ответа в формат XML.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http\Response
 * @since 2.0
 */
class XmlResponseFormatter extends AbstractResponseFormatter
{
    /**
     * {@inheritdoc}
     */
    public function prepare(\Gm\Http\Response $response): void
    {
        $response->getHeaders()->add('content-type', 'application/xml');
    }

    /**
     * {@inheritdoc}
     */
    public function format(\Gm\Http\Response $response, mixed $content): mixed
    {
        // добавление к контенту исключений
        if ($response->exceptionContent) {
            $content .= $response->exceptionContent;
        }
        return $content;
    }
}
