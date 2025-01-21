<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View;

use Gm\View\Helper\HelperInterface;

/**
 * Менеджер помощников для модели представления.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View
 * @since 2.0
 */
class HelperManager
{
    /**
     * Псевдонимы классов помощников.
     *
     * @var array
     */
    protected array $invokableClasses = [
        'stylesheet' => 'Gm\View\Helper\Stylesheet',
        'script'     => 'Gm\View\Helper\Script',
        'link'       => 'Gm\View\Helper\Link',
        'meta'       => 'Gm\View\Helper\Meta',
        'openGraph'  => 'Gm\View\Helper\OpenGraph\OpenGraph',
        'favicon'    => 'Gm\View\Helper\Favicon',
        'html'       => 'Gm\View\Helper\Html',
    ];

    /**
     * Помощники.
     * 
     * @var array<string, HelperInterface>
     */
    protected array $helpers = [];

    /**
     * Возвращает названия класса помощника.
     * 
     * @param string $name Название помощника.
     * 
     * @return string|false
     */
    public function getInvokableClass(string $name): string|false
    {
        return isset($this->invokableClasses[$name]) ? $this->invokableClasses[$name] : false;
    }

    /**
     * Возвращает помощника.
     * 
     * @see HelperManager::addHelper()
     * 
     * @param string $name Название помощника.
     * 
     * @return HelperInterface|null Возвращает значение `null`, если класс помощника 
     *     не найден.
     */
    public function getHelper(string $name): ?HelperInterface
    {
        if (isset($this->helpers[$name])) {
            return $this->helpers[$name];
        }
        return $this->addHelper($name);
    }

    /**
     * Создаёт помощника, если он не был создан ранее.
     * 
     * @param string $name Название помощника.
     * 
     * @return HelperInterface|null Возвращает значение `null`, если класс помощника 
     *     не найден.
     */
    public function addHelper(string $name): ?HelperInterface
    {
        $class = $this->getInvokableClass($name);
        if ($class === false) {
            return null;
        }
        return $this->helpers[$name] = new $class();
    }

    /**
     * Удаляет помощника.
     * 
     * @param string $name Название помощника.
     * 
     * @return $this
     */
    public function removeHelper(string $name): static
    {
        if (isset($this->helpers[$name])) {
            unset($this->helpers[$name]);
        }
        return $this;
    }

    /**
     * Проверяет, был ли создан помощник с указанным именем.
     * 
     * @param string $name Название помощника.
     * 
     * @return bool
     */
    public function hasHelper(string $name): bool
    {
        return isset($this->helpers[$name]);
    }

    /**
     * Возвращает помощника.
     * 
     * @see HelperManager::getHelper()
     * 
     * @param string $name Название помощника.
     * 
     * @return HelperInterface|null Возвращает значение `null`, если класс помощника 
     *     не найден.
     */
    public function get(string $name): ?HelperInterface
    {
        return $this->getHelper($name);
    }
}
