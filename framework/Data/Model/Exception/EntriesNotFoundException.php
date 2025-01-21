<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @see https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Data\Model\Exception;

use Gm\Exception\UserException;

/**
 * Исключения возникающие при отсутствии записей (элементов).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Data\Model\Exception
 * @since 2.0
 */
class EntriesNotFoundException extends UserException
{
    /**
     * {@inheritdoc}
     */
    public bool $report = false;

    /**
     * {@inheritdoc}
     */
    public function getMessageBox(): array
    {
        return [
            'icon'   => 'icon-warning',
            'status' => '#Warning',
            'text'   => $this->message
        ];
    }
}
