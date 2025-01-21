<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Generator;

/**
 * Трейт генерации имён (Фамилия Имя Отчество).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
trait NamesGeneratorTrait
{
    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->addPatternName('names', 'patterns\names.pattern.php');
    }

    /**
     * Возвращает случайное отчество для мужского имени.
     * 
     * @param string $name Мужское имя.
     * 
     * @return string
     */
    public function malePatronymic(string $name): string
    {
        $begin = mb_substr($name, 0, -2);
        $end   = mb_substr($name, -2, 2);

        if ($end === 'ий') {
            return $begin . 'ьевич';
        }
        if ($end === 'ей') {
            return $begin . 'еевич';
        }
        if ($end[1] === 'ь') {
            return $begin . $end[0] . 'евич';
        }
        if ($end[1] === 'а') {
            return $begin . $end[0] . 'ович';
        }
        return $name . 'ович';
    }

    /**
     * Возвращает случайное отчество для женского имени.
     * 
     * @param string $name Женское имя.
     * 
     * @return string
     */
    public function femalePatronymic(string $name): string
    {
        $begin = mb_substr($name, 0, -2);
        $end   = mb_substr($name, -2, 2);

        if ($end === 'ий') {
            return $begin . 'ьевна';
        }
        if ($end === 'ей') {
            return $begin . 'еевна';
        }
        if ($end[1] === 'ь') {
            return $begin . $end[0] . 'евна';
        }
        if ($end[1] === 'а') {
            return $begin . $end[0] . 'новна';
        }
        return $name . 'овна';
    }

    /**
     * Возвращает случайные отчества для мужских имён.
     * 
     * @return array
     */
    public function malePatronymics(): array
    {
        $maleNames = &$this->patterns['names']['maleNames'];
        $patronymics = [];
        foreach($maleNames as $name) {
            $patronymics[] = $this->malePatronymic($name);
        }
        return $patronymics;
    }

    /**
     * Возвращает случайные отчества для женских имён.
     * 
     * @return array
     */
    public function femalePatronymics(): array
    {
        $maleNames = &$this->patterns['names']['maleNames'];
        $patronymics = [];
        foreach($maleNames as $name) {
            $patronymics[] = $this->femalePatronymic($name);
        }
        return $patronymics;
    }

    /**
     * Возвращает случайные полные имена - Фамилия Имя Отчество (мужское).
     * 
     * @param int $maxSurnames Максимальное количество Фамилий.
     * @param int $maxNames Максимальное количество Имён.
     * @param int $maxPatronymics Максимальное количество Отчеств.
     * 
     * @return array
     */
    public function genMaleFullname(int $maxSurnames = 0, int $maxNames = 0, int $maxPatronymics = 0): array
    {
        $result      = [];
        $surnames    = &$this->patterns['names']['maleSurnames'];
        $names       = &$this->patterns['names']['maleNames'];
        $patronymics = $this->malePatronymics();
        $totalSurnames    = sizeof($surnames);
        $totalNames       = sizeof($names);
        $totalPatronymics = sizeof($patronymics);
        // фамилии
        if ($maxSurnames > sizeof($surnames) || $maxSurnames == 0)
            $countSurnames = sizeof($surnames);
        else
            $countSurnames = $maxSurnames;
        // имена
        if ($maxNames === null)
            $countNames = 0;
        else {
            if ($maxNames > sizeof($names) || $maxNames == 0)
                $countNames = sizeof($names);
            else
                $countNames = $maxNames;
        }
        // отчества
        if ($maxPatronymics === null)
            $countPatronymics = 0;
        else
            $countPatronymics = $maxPatronymics;

        // фамилии
        for($i = 0; $i < $countSurnames; $i++)
        {
            if ($countNames) {
                // имена
                for($j = 0; $j < $countNames; $j++)
                {
                    if ($countPatronymics) {
                        // фамилии
                        for($z = 0; $z < $countPatronymics; $z++)
                        {
                            $surnameIndex    = rand(0, $totalSurnames - 1);
                            $nameIndex       = rand(0, $totalNames - 1);
                            $patronymicIndex = rand(0, $totalPatronymics - 1);
                            $result[] = array(
                                'name'           => $surnames[$surnameIndex] . ' ' . $names[$nameIndex] . ' ' . $patronymics[$patronymicIndex],
                                'firstName'      => $names[$nameIndex],
                                'secondName'     => $surnames[$surnameIndex],
                                'patronymicName' => $patronymics[$patronymicIndex]
                            );
                        }
                    } else {
                        $surnameIndex = rand(0, $totalSurnames - 1);
                        $nameIndex    = rand(0, $totalNames - 1);
                        $result[] = array(
                            'name'           => $surnames[$surnameIndex] . ' ' . $names[$nameIndex],
                            'firstName'      => $names[$nameIndex],
                            'secondName'     => $surnames[$surnameIndex],
                            'patronymicName' => null
                        );
                    }
                }
            } else {
                $surnameIndex = rand(0, $totalSurnames - 1);
                $result[] = array(
                    'name'           => $surnames[$surnameIndex],
                    'firstName'      => null,
                    'secondName'     => $surnames[$surnameIndex],
                    'patronymicName' => null
                );
            }
        }
        return $result;
    }

    /**
     *  Возвращает случайные полные имена - Фамилия Имя Отчество (женское).
     * 
     * @link http://megagenerator.ru/namefio/
     * 
     * @param int $maxSurnames Максимальное количество Фамилий.
     * @param int $maxNames Максимальное количество Имён.
     * @param int $maxPatronymics Максимальное количество Отчеств.
     * 
     * @return array
     */
    public function genFemaleFullname(int $maxSurnames = 0, int $maxNames = 0, int $maxPatronymics = 0): array
    {

        $result      = [];
        $surnames    = &$this->patterns['names']['femaleSurnames'];
        $names       = &$this->patterns['names']['femaleNames'];
        $patronymics = $this->femalePatronymics();
        $totalSurnames    = sizeof($surnames);
        $totalNames       = sizeof($names);
        $totalPatronymics = sizeof($patronymics);
        // фамилии
        if ($maxSurnames > $totalSurnames || $maxSurnames == 0)
            $countSurnames = $totalSurnames;
        else
            $countSurnames = $maxSurnames;
        // имена
        if ($maxNames === null)
            $countNames = 0;
        else {
            if ($maxNames > $totalNames || $maxNames == 0)
                $countNames = $totalNames;
            else
                $countNames = $maxNames;
        }
        // отчества
        if ($maxPatronymics === null)
            $countPatronymics = 0;
        else
            $countPatronymics = $maxPatronymics;

        // фамилии
        for($i = 0; $i < $countSurnames; $i++)
        {
            if ($countNames) {
                // имена
                for($j = 0; $j < $countNames; $j++)
                {
                    if ($countPatronymics) {
                        // отчества
                        for($z = 0; $z < $countPatronymics; $z++)
                        {
                            $surnameIndex    = rand(0, $totalSurnames - 1);
                            $nameIndex       = rand(0, $totalNames - 1);
                            $patronymicIndex = rand(0, $totalPatronymics - 1);
                            $result[] = array(
                                'name'           => $surnames[$surnameIndex] . ' ' . $names[$nameIndex] . ' ' . $patronymics[$patronymicIndex],
                                'firstName'      => $names[$nameIndex],
                                'secondName'     => $surnames[$surnameIndex],
                                'patronymicName' => $patronymics[$patronymicIndex]
                            );
                        }
                    } else {
                        $surnameIndex = rand(0, $totalSurnames - 1);
                        $nameIndex    = rand(0, $totalNames - 1);
                        $result[] = array(
                            'name'           => $surnames[$surnameIndex] . ' ' . $names[$nameIndex],
                            'firstName'      => $names[$nameIndex],
                            'secondName'     => $surnames[$surnameIndex],
                            'patronymicName' => null
                        );
                    }
                }
            } else {
                $surnameIndex = rand(0, $totalSurnames - 1);
                $result[] = array(
                    'name'           => $surnames[$surnameIndex],
                    'firstName'      => null,
                    'secondName'     => $surnames[$surnameIndex],
                    'patronymicName' => null
                );
            }
        }
        return $result;
    }

}
