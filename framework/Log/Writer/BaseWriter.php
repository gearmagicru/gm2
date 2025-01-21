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
 * Базовый класс писателя журнала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Log\Writer
 * @since 2.0
 */
class BaseWriter extends AbstractWriter
{
    /**
     * Спецификатор формата для сообщений журнала.
     * 
     * Устанавливается в опциях ($options) конструктора класса {@AbstractWriter}.
     * 
     * @var string
     */
    public string $formatMessage = '[%timestamp%] %priorityName% (%priority%): %message% %extra%';

    /**
     * Формат даты и времени сообщения.
     * 
     * Устанавливается в опциях ($options) конструктора класса {@AbstractWriter}.
     * 
     * @var string
     */
    public string $formatDateTime = 'php:d-m-Y H:i:s';

    /**
     * {@inheritdoc}
     */
    public function filterMessage(array $message): array
    {
        if ($this->prioritiesMap && $this->prioritiesMap !== 1) {
            return in_array($message['priority'], $this->prioritiesMap) ? $message : null;
        }
        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function formatValue(string $key, mixed $value): mixed 
    {
        if ($key === 'timestamp') {
            return Gm::$app->formatter->toDateTime($value, $this->formatDateTime);
        }
        return parent::formatValue($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function formatMessage(array $message): string|array
    {
        $output  = $this->formatMessage;

        foreach ($message as $key => $value) {
            $value = $this->formatValue($key, $value);
            $output = str_replace("%$key%", (string) $value, $output);
        }
        return $output;
    }
}
