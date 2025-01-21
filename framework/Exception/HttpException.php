<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

use Throwable;
use Gm\Http\Response;

/**
 * Исключение представлено в виде ошибки HTTP с указанным состояния.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class HttpException extends UserException
{
    /**
     * Код статуса.
     * 
     * @var int
     */
    public int $statusCode;

    /**
     * Конструктор класса.
     * 
     * @param string statusCode Код статуса.
     * @param string $message Текст ошибки  (по умолчанию '').
     * @param int $code Код ошибки  (по умолчанию 0).
     * @param Throwable|null $previous Предыдущие исключение (по умолчанию `null`).
     * 
     * @return void
     */
    public function __construct(int $status, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->statusCode = $status;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatchMessage(): string
    {
        if (isset(Response::$recommendedReasonPhrases[$this->statusCode]))
            return Response::$recommendedReasonPhrases[$this->statusCode];
        else
            return sprintf('Forbidden" HTTP exception with status code %s.', $this->statusCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'HTTP Error #' . $this->statusCode;
    }
}
