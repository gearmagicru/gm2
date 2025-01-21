<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View;

use Gm\Stdlib\BaseObject;

/**
 * Базовый класс виджета для формирования элементов интерфейса в представлении.
 * 
 * Базовый класс виджета имеет все методы и свойства необходимые для вызова его из 
 * {@see \Gm\View\BaseView::widget()} Менеджером виджетов {@see \Gm\WidgetManager\WidgetManager}.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Widget
 * @since 2.0
 */
class BaseWidget extends BaseObject
{
    /**
     * Файл последнего шаблона из которого был вызван виджет.
     * 
     * Устанавливается в конструкторе виджета параметром конфигурации.
     * 
     * @see \Gm\View\BaseView::widget()
     * 
     * @var string
     */
    public string $calledFromViewFile = '';

    /**
     * Изменять конфигурацию виджета, когда виджет уже создан.
     * 
     * Это свойство указывается владельцам (менеджеру) виджета, что виджет готов поменять
     * свою конфигурацию.
     * 
     * Пример:
     * ```php
     * $widget = new \Gm\Widget\FooBar(['width' => 500]);
     * if ($widget->useReconfigure) {
     *     $widget->configure(['width' => 700]);
     * }
     * ```
     * 
     * @var bool
     */
    public bool $useReconfigure = false;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->init();
    }

    /**
     * Инициализация виджета.
     * 
     * Этот метод вызывается в конце конструктора после инициализации вижета 
     * заданной конфигурацией.
     * 
     * @return void
     */
    public function init(): void
    {
    }

    /**
     * Выводит визуализацию содержимого виджета.
     * 
     * @return string
     */
    public function renderMe(): string
    {
        ob_start();
        ob_implicit_flush(false);
        try {
            $result = '';
            if ($this->beforeRun()) {
                $result = $this->run();
                $result = $this->afterRun($result);
            }
        } catch (\Exception $e) {
            // закрыть открытый буфер вывода, если он еще не был закрыт
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }
        return ob_get_clean() . $result;
    }

    /**
     * Событие перед запуском виджета. 
     * 
     * @return bool Возвращает значение `true`, если продолжить запуск виджета.
     */
    public function beforeRun(): bool
    {
        return true;
    }

    /**
     * Событие после запуска виджета. 
     * 
     * @param mixed $result Содержимое полученное после запуска виджета.
     * 
     * @return mixed
     */
    public function afterRun(mixed $result): mixed
    {
        return $result;
    }

    /**
     * Выполняет запуск виджета.
     * 
     * @return mixed
     */
    public function run(): mixed
    {
        return '';
    }
}
