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
 * Валидатор "Captcha" (проверка кода капчи).
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Validator
 * @since 2.0
 */
class KCaptcha extends AbstractValidator
{
    public const NOT_MATCH = 'notMatch';

    /**
     * {@inheritdoc}
     */
    protected array $messageTemplates = [
        self::NOT_MATCH => 'You entered the code incorrectly'
    ];

    /**
     * {@inheritdoc}
     */
    protected array $options = [
        'param' => 'kcaptcha'
    ];

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options): static
    {
        $options = array_merge($this->options, $options);

        if (empty($options['param'])) {
            throw new Exception\InvalidArgumentException(Gm::t('app', 'Missing option. "param" have to be given'));
        }
        $this->options = $options;
        return $this;
    }

    /**
     * Возвращает имя переменной сессии (код капчи).
     *
     * @return string
     */
    public function getParam(): string
    {
        return $this->options['param'];
    }

    /**
     * Устанавливает имя переменной сессии (код капчи).
     *
     * @param string $param Имя переменной сессии (код капчи)
     * 
     * @return $this
     */
    public function setParam(string $param): static
    {
        $this->options['param'] = $param;
        return $this;
    }

    /**
     * Возвращает значение `true`, если и только если $value совпадает с кодом капчи.
     * 
     * {@inheritdoc}
     */
    public function isValid(mixed $value): bool
    {
        $this->setValue($value);

        /** @var \Gm\Session\Session $session */
        $session = Gm::$services->getAs('session');
        $session->open();

        $key = $session->get($this->getParam());
        $session->set($this->getParam(), null);

        if ($key !== $value) {
            $this->error(self::NOT_MATCH);
            return false;
        }
        return true;
    }
}
