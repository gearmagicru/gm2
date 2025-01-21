<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Permissions\Rbac\Assertion;

use Gm\Permissions\Rbac\Rbac;
use Gm\Permissions\Rbac\AssertionInterface;
use Gm\Permissions\Rbac\Exception\InvalidArgumentException;

/**
 * Класс обратного вызова утверждения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Permissions\Rbac\Assertion
 * @since 2.0
 */
class CallbackAssertion implements AssertionInterface
{
    /**
     * @var callable Обратный вызов.
     */
    protected callable $callback;

    /**
     * @param callable $callback
     * 
     * @throws InvalidArgumentException Не установлен обратный вызов.
     */
    public function __construct(callable $callback)
    {
        if (! is_callable($callback)) {
            throw new InvalidArgumentException('Invalid callback provided, not callable');
        }
        $this->callback = $callback;
    }

    /**
     * Метод утверждения - должен возвращать логическое значение.
     *
     * Возвращает результат выполненного обратного вызова.
     *
     * @param Rbac $rbac
     * 
     * @return bool
     */
    public function assert(Rbac $rbac): bool
    {
        return (bool) call_user_func($this->callback, $rbac);
    }
}
