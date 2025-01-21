<?php
/**
 * Gm Panel
 * 
 * @link https://gearmagic.ru/gpanel/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/gpanel/license/
 */

namespace Gm\Generator;

/**
 * Генератор записей таблицы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Generator
 * @since 2.0
 */
class TableGenerator extends BaseGenerator
{
    use FormatGeneratorTrait, NamesGeneratorTrait, TableGeneratorTrait {
        FormatGeneratorTrait::init as formatInit;
        NamesGeneratorTrait::init  as namesInit;
        TableGeneratorTrait::init  as tableInit;
    }

    /**
     * Имя таблицы.
     * 
     * @var string
     */
    public string $tableName = '';

    /**
     * Количество генерируемых записей в таблице.
     * 
     * @var int
     */
    public int $countRows = 1;

    /**
     * Идентификаторы записей таблицы полученные после генерации записей.
     * 
     *  @see TableGenerator::generate()
     * 
     * @var array
     */
    protected array $rowsId = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->formatInit();
        $this->namesInit();
        $this->tableInit();

        parent::init();
    }

    /**
     * Возвращает имена полей таблицы с их значениями в виде пар "ключ - значение".
     * 
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [];
    }

    /**
     * Событие "до" генерации записей.
     * 
     * @return void
     */
    protected function beforeGenerate(): void
    {
    }

    /**
     * Событие "после" генерации записей.
     * 
     * @return void
     */
    protected function afterGenerate(): void
    {
    }

    /**
     * Генерирует записи таблицы.
     * 
     * @see TableGenerator::beforeGenerate()
     * @see TableGenerator::afterGenerate()
     * 
     * @return void
     */
    public function generate(): void
    {
        $this->beforeGenerate();
        for ($i = 0; $i < $this->countRows; $i++) {
            $this->rowsId[] = (int) $this->addTableRow($this->getTableColumns());
        }
        $this->afterGenerate();
    }
}
