<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Permissions\Mbac\Model;

use Gm\Db\ActiveRecord;

/**
 * Шаблон данных, реализующий хранение ролей пользователей.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Permissions\Mbac\Model
 * @since 2.0
 */
class Role extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function primaryKey(): string
    {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function tableName(): string
    {
        return '{{role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function maskedAttributes(): array
    {
        return [
            'id'           => 'id', // идентификатор
            'name'         => 'name', // название
            'shortname'    => 'shortname', // короткое название
            'description'  => 'description', // описание
            // системные
            'updatedDate' => '_updated_date',
            'updatedUser' => '_updated_user',
            'createdDate' => '_created_date',
            'createdUser' => '_created_user',
            'lock'        => '_lock'
        ];
    }
}
