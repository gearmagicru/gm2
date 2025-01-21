<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator;

use Gm;

/**
 * Трейт форматирования данных и их генерация.
 * 
 * Форматирование и генерациия случайных: дат, времени, номеров телефонов, email и т.д.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
trait  FormatGeneratorTrait
{
    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->addPatternName('mails', 'patterns\mails.pattern.php');
        $this->addPatternName('phones', 'patterns\phones.pattern.php');
    }

    /**
     * Возвращает текущую дату.
     * 
     * @return string
     */
    public function getDateNow(): string
    {
        return Gm::$app->formatter->toDateTime('now', 'php:Y-m-d');
    }

    /**
     * Возвращает текущее время.
     * 
     * @return string
     */
    public function getDateTimeNow(): string
    {
        return Gm::$app->formatter->toDateTime('now', 'php:Y-m-d H:i:s');
    }

    /**
     * Форматирует дату.
     * 
     * @param string $date Дата.
     * @param string $modifier Модификатор.
     * @param string $format Формат даты.
     * 
     * @return string
     */
    public function dateModify(string $date, string $modifier, string $format = 'Y-m-d'): string
    {
        return (new \DateTime($date))
            ->modify($modifier)
            ->format($format);
    }

    /**
     * Форматирует время.
     * 
     * @param string $dateTime Время.
     * @param string $modifier Модификатор.
     * @param mixed string Формат даты и времени.
     * 
     * @return string
     */
    public function dateTimeModify(string $dateTime, string $modifier, string $format = 'Y-m-d H:i:s'): string
    {
        return (new \DateTime($dateTime))
            ->modify($modifier)
            ->format($format);
    }

   /**
     * Возвращает email.
     * 
     * @param string $box Имя ящика.
     * @param array $providers Имя провайдера.
     * 
     * @return string
     */
    public function randEmail(string $box): string
    {
        if ($mail = $this->random('mails')) {
            return str_replace([' ', '\''], ['.', ''], strtolower($box)) . '@' . $mail;
        }
        return '';
    }

    /**
     * Возвращает случайную дату из указанного интервала.
     * 
     * @param string $from Интервал даты.
     * @param string $to Интервал даты.
     * @param string $format Формат возвращаемой даты.
     * @param bool $reset Сброс интервала даты.
     * 
     * @return string
     */
    public function randDate(string $from, string $to, string $format = 'Y-m-d', bool $reset = false): string
    {
        static $interval, $dateTo, $dateFrom;

        if ($reset || $interval === null) {
            $dateFrom = new \DateTime($from . ' 00:00:01');
            $dateTo   = new \DateTime($to . ' 00:00:01');
            $interval = $dateFrom->diff($dateTo);
        }
        return date($format, mktime(0, 0, 0,
            $dateFrom->format('m'),
            $dateFrom->format('d') + rand(0, $interval->days),
            $dateFrom->format('Y'))
        );
    }

    /**
     * Возвращает случайное время.
     * 
     * @param string $format Формат времени.
     * 
     * @return string
     */
    public function randTime(string $format = 'H:i:s'): string
    {
        $second = rand(0, 59);
        if (strlen($second) == 1) {
            $second = '0' . $second;
        }
        $minute = rand(0, 59);
        if (strlen($minute) == 1) {
            $minute = '0' . $minute;
        }
        $houre = rand(0, 24);
        if (strlen($houre) == 1) {
            $houre = '0' . $houre;
        }
        return (new \DateTime("NOW $houre:$minute:$second"))->format($format);
    }

    /**
     * Возвращает случайный true или false.
     * 
     * @return bool
     */
    public function randBool(): bool
    {
        return rand(0, 1) ? true : false;
    }

    /**
     * Возвращает случайное значение 1 или 0.
     * 
     * @return int
     */
    public function randOne(): int
    {
        return rand(0, 1);
    }

    /**
     * Возвращает случайный номер страны.
     * 
     * @return string|false
     */
    public function randPhoneCountry(): false|string
    {
        if (!isset($this->patterns['phones']['countries'])) {
            return '';
        }

        $pattern = &$this->patterns['phones']['countries'];
        $size = sizeof($pattern);
        if ($size == 0) {
            return false;
        }
        $index = rand(0, $size - 1);
        return $pattern[$index] ?? false;
    }

    /**
     * Возвращает случайный телефонный оператор согласно указанному коду.
     * 
     * @param string $countryCode Код страны.
     * 
     * @return string|false
     */
    public function randPhoneOperator(string $countryCode): false|string
    {
        if (!isset($this->patterns['phones']['operators'])) {
            return '';
        }
        $pattern = &$this->patterns['phones']['operators'];
        if (!isset($pattern[$countryCode])) {
            return '';
        }
        $operators = &$pattern[$countryCode];
        $size = sizeof($operators);
        if ($size == 0) {
            return false;
        }
        $index = rand(0, $size - 1);
        return $operators[$index] ?? false;
    }

    /**
     * Возвращает номер телефона.
     * 
     * @link https://support.twilio.com/hc/en-us/articles/223183008-Formatting-International-Phone-Numbers
     * @link https://en.wikipedia.org/wiki/National_conventions_for_writing_telephone_numbers
     * 
     * @param array $countryCodes Коды стран.
     * @param array $areaCodes Коды операторов.
     * @param string $format Формат номера телефона.
     * 
     * @return array
     */
    public function randPhone(string $countryCode, string $operatorCode, string $format): array
    {
        $C    = $countryCode;
        $AAA  = $operatorCode;
        $BBBB = rand(1000, 9999);
        $BBB  = rand(100, 999);
        $BB1  = rand(10, 99);
        $BB2  = rand(10, 99);
        switch($format) {
            case 'C (AAA) BBB-BB-BB':  $phone = "$C ($AAA) $BBB-$BB1-$BB2"; break;
            case 'C AAA BBB-BB-BB':    $phone = "$C $AAA $BBB-$BB1-$BB2"; break;
            case 'C AAA BBB-BBBB':     $phone = "$C $AAA $BBB-$BBBB"; break;
            case 'C AAA BBBBBBB':      $phone = "$C $AAA $BBB-$BB1-$BB2"; break;
            case 'CAAABBBBBBB':        $phone = "$C$AAA$BBBB$BBB"; break;
            case '+C (AAA) BBB-BB-BB': $phone = "$C $AAA $BBB-$BB1-$BB2"; break;
            case '+C AAA BBB-BB-BB':   $phone = "+$C $AAA $BBB-$BB1-$BB2"; break;
            case '+C AAA BBB-BBBB':    $phone = "+$C $AAA $BBB-$BBBB"; break;
            case '+C AAA BBBBBBB':     $phone = "+$C $AAA $BBBB$BBB"; break;
            case '+CAAABBBBBBB':       $phone = "$C$AAA$BBBB$BBB"; break;
            case '(AAA) BBB-BB-BB':    $phone = "($AAA) $BBB-$BB1-$BB2"; break;
            case 'AAA BBB-BB-BB':      $phone = "$AAA $BBB-$BB1-$BB2"; break;
            case 'AAA BBB-BBBB':       $phone = "$AAA $BBB-$BBBB"; break;
            case 'AAA BBBBBBB':        $phone = "$AAA $BBBB$BBB"; break;
            case 'AAABBBBBBB':         $phone = "$AAA $BBBB$BBB"; break;
        }
        return [$phone, "$C$AAA$BBBB$BBB"];
    }
}
