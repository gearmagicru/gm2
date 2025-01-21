<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Exception;

use Gm\Exception;

/**
 * Исключение возникающие при работе Карты SQL-запросов.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Db\Exception
 * @since 2.0
 */
class QueriesMapException extends Exception\UserException
{
    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return 'Queries map exception';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Queries map exception';
    }
}
