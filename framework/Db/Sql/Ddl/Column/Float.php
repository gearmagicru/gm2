<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */
namespace Gm\Db\Sql\Ddl\Column;

/**
 * Класс-заглушка для обратной совместимости.
 *
 * Поскольку PHP 7 добавляет "float" в качестве зарезервированного ключевого слова, 
 * то мы больше не можем иметь класс с таким именем и сохранять совместимость с PHP 7. 
 * Исходный класс был переименован в "Floating", и теперь этот класс является его 
 * расширением. Он вызывает E_USER_DEPRECATED, чтобы предупредить пользователей 
 * о необходимости миграции.
 *
 * @deprecated
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @author Zend Framework (http://framework.zend.com/)
 * @package Gm\Db\Sql\Ddl
 * @since 2.0
 */
class Float extends Floating
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $name = '', 
        int $digits = 0, 
        int $decimal = 0, 
        bool $nullable = false, 
        mixed $default = null, 
        array $options = []
    ) {
        trigger_error(
            sprintf(
                'The class %s has been deprecated; please use %s\\Floating',
                __CLASS__,
                __NAMESPACE__
            ),
            E_USER_DEPRECATED
        );

        parent::__construct($name, $digits, $decimal, $nullable, $default, $options);
    }
}
