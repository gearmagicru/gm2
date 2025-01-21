<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Validator;

use Gm;

/**
 * Менеджер валидации входных данных.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Validator
 * @since 2.0
 */
class ValidatorManager
{
    /**
     * Имена валидаторов с их классами.
     *
     * @var array
     */
    public array $aliases = [
        'compare'  => '\Gm\Validator\Compare',
        'between'  => '\Gm\Validator\Between',
        'notEmpty' => '\Gm\Validator\NotEmpty',
        'select'   => '\Gm\Validator\Select',
        'match'    => '\Gm\Validator\PregMatch',
        'filename' => '\Gm\Validator\Filename',
        'filter'   => '\Gm\Validator\Filter',
        'enum'     => '\Gm\Validator\Enum',
        'kcaptcha' => '\Gm\Validator\KCaptcha',
    ];

    /**
     * Сообщения (ошибки).
     *
     * @var array
     */
    protected array $messages = [];

    /**
     * Возвращает валидатор.
     * 
     * @param string $name Имя валидатора.
     * @param array $options Параметры настроек валидатора.
     * 
     * @return AbstractValidator
     * 
     * @throws \Gm\Exception\NotInstantiableException Ошибка при создании экземпляра класса валидатора.
     */
    public function getValidator(string $name, array $options = []): AbstractValidator
    {
        $alias = $name . 'Validator';
        if (!Gm::$services->has($alias)) {
            Gm::$services->setInvokableClass($alias, $this->aliases[$name]);
        }
        /** @var AbstractValidator $validator */
        $validator = Gm::$services->getAs($alias);
        $validator->setOptions($options);
        return $validator;
    }

    /**
     * Проверяет значение.
     * 
     * @param mixed $value Проверяемое значение.
     * @param string $name Имя валидатора.
     * @param array $options Параметры настроек валидатора.
     * 
     * @return bool|array Если значение `array`, то возвратит сообщения об ошибках проверки.
     * 
     * @throws \Gm\Exception\NotInstantiableException Ошибка при создании экземпляра класса валидатора.
     */
    public function isValid(mixed $value, string $name, array $options = []): bool|array
    {
        /** @var AbstractValidator $validator */
        $validator = $this->getValidator($name, $options);
        if ($validator->isValid($value)) return true;

        return $validator->getMessages();
    }

    /**
     * Выполняет проверку значения.
     * 
     * @param array $rules Правила проверки.
     * @param array $attributes Название атрибутов с их значениями, которые необходимо проверить.
     * 
     * @return bool
     */
    public function validate(array $rules, array $attributes): bool
    {
        foreach ($rules as $ruleName => $rule) {
            $names   = (array) $rule[0];
            $name    = $rule[1];
            $options = array_slice($rule, 2);
            foreach ($names as $attributeName) {
                try {
                    $value = $attributes[$attributeName] ?? null;

                    /** @var AbstractValidator $validator */
                    $validator = $this->getValidator($name, $options);
                    if (!$validator->isValid($value)) {
                        $messages = $validator->getMessages();
                        if (sizeof($messages) > 0) {
                            $this->messages[] = array($messages[0], $attributeName);
                        }
                    }
                } catch(\Exception $e) {
                    $this->messages[] = array($e->getMessage(), $attributeName);
                }
            }
        }
        return sizeof($this->messages) == 0;
    }

    /**
     * Возвращает сообщения (ошибки) полученные при проверки атрибутов.
     * 
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
