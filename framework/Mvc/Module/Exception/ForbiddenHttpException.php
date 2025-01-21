<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Module\Exception;

use Gm\Exception;

/**
 * Исключение возникающие при ограниченном доступе к модулю.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Module\Exception
 * @since 2.0
 */
class ForbiddenHttpException extends Exception\ForbiddenHttpException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return 'You are not allowed to perform this action';
    }
}
