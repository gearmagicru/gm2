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
 * Класс Форматтера для форматирования HTTP-ответа в формат JSON.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http
 * @since 2.0
 */
class JsonResponseFormatter extends AbstractResponseFormatter
{
    /**
     * {@inheritdoc}
     */
    public function prepare(\Gm\Http\Response $response): void
    {
        $response->getHeaders()->add('content-type', 'application/json');
    }
}
