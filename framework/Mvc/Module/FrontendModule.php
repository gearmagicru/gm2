<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @see https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Mvc\Module;

/**
 * Класс модуля `FRONTEND` для всех классов-наследников модуля.
 * 
 * В поведениях (behaviors) модуля при вызове из `BACKEND` указаны правила доступа, 
 * но для `FRONTEND` поведения отсутствуют.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Mvc\Module
 * @since 2.0
 */
class FrontendModule extends Module
{
    /**
     * {@inheritdoc}
     * 
     * В данном случаи, разрешения роли пользователя проверяются только для 
     * Панели управления.
     */
    public function behaviors(): array
    {
        if (IS_FRONTEND) return [];

        return [
            'access' => [
                'class'    => '\Gm\Filter\AccessControl',
                'autoInit' => true,
                'rules'    => $this->getConfigParam('accessRules')
            ]
        ];
    }
}
