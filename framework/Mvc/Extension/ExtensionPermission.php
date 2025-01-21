<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @see https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Extension;

use Gm\Mvc\Module\ModulePermission;

/**
 * Класс Разрешения, определяющий доступ к действию контроллера расширения модуля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Extension
 * @since 2.0
 */
class ExtensionPermission extends ModulePermission
{
    /**
     * Проверяет доступность расширения модуля по указанному разрешению.
     * 
     * @param mixed $permission Имя разрешения.
     * 
     * @return bool Если значение `true`, то расширение с указанным разрешением доступен.
     */
    public function isGranted(string $permission): bool
    {
        return $this->user->isGranted($permission, true);
    }
}
