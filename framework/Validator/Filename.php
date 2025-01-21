<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Validator;

/**
 * Валидатор "Filename" (проверка имени файла или директории).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Validator
 * @since 2.0
 */
class Filename extends PregMatch
{
    /**
     * {@inheritdoc}
     */
    protected array $options = [
        'format'  => '/^[a-zA-Z0-9_\-\.]+$/', 
        'message' => ''
    ];
}
