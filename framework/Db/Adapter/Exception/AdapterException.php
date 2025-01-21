<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Db\Adapter\Exception;

use Throwable;
use Gm\Exception\HttpException;

/**
 * Исключение при работе адаптера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Db\Adapter\Exception
 * @since 2.0
 */
class AdapterException extends HttpException
{
    /**
     * {@inheritdoc}
     */
    public string $viewFile = '//errors/database';

    /**
     * {@inheritdoc}
     */
    public string $error = '';

    /**
     * {@inheritdoc}
     * 
     * @param string $error Текст ошибки (по умолчанию '').
     */
    public function __construct(string $message = '', string $error = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->error = $error;
        if (is_string($error)) {
            $message .= ' (' . $error . ').';
        }

        parent::__construct(503, $message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        return sprintf('Database adapter error "%s"', $this->error ?: 'unknow');
    }
}