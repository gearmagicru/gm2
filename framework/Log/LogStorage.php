<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Log;

use Gm\Session\Storage\SessionStorage;

/**
 * Хранилище записей журнала в сессии.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Log
 * @since 2.0
 */
class LogStorage extends SessionStorage
{
    /**
     * {@inheritdoc}
     */
    protected $namespace = 'Gm_Storage';
}
