<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Log\Writer;

use Gm;

/**
 * Класс писателя отсылаемых писем в файл журнала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Log\Writer
 * @since 2.0
 */
class MailWriter extends FileWriter
{
    /**
     * {@inheritdoc}
     */
    public string $formatMessage = "[%timestamp%]  %message% \r\n%body%";

    /**
     * {@inheritdoc}
     */
    public function write(array $message): void
    {
        $msg = $message['message'];
        if (is_array($msg)) {
            $message['message'] = $msg['message'] ?? '';
            $message['body']    = $$msg['body'] ?? '';
        }

        parent::write($message);
    }
}
