<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Stdlib;

use Gm;

/**
 * Служба (сервис) - это класс, расширяющий возможности компонента за счёт определения 
 * своих параметров через унифицированный конфигуратор.
 * 
 * Все службы управляются менеджером служб {@see \Gm\ServiceManager\ServiceManager}.
 * C помощью менеджера, службы можно отключать и подключать.
 * Каждая служба может хранить значения своих параметры в общем файле конфигурации и 
 * использовать их с помощью унифицированного конфигуратора {@see \Gm\Mvc\Application::$unifiedConfig}.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Stdlib
 * @since 2.0
 */
class Service extends Component
{
    /**
     * Использовать унифицированный конфигуратор для определения параметров службы.
     * 
     * Если значение `true`, будет применяться параметры из раздела {@see Service::getObjectName()}
     * унифицированного конфигуратора.
     * 
     * @var bool
     */
    protected bool $useUnifiedConfig = false;

    /**
     * Устанавливает, будет ли служба доступа.
     * 
     * Если значение `true`, функционал службы должен быть ограничен.
     * 
     * @var bool
     */
    public bool $enabled = true;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        $this->configure($config);

        $this->init();
        $this->initVariables();
    }

    /**
     * {@inheritdoc}
     * 
     * @see \Gm\Stdlib\BaseObject::configure()
     */
    public function configure(array $config): void
    {
        if ($config || $this->useUnifiedConfig) {
            Gm::configure($this, $config, $this->useUnifiedConfig);
        }
    }

    /**
     * Инициализация переменных службы, которые можно считать глобальными для всего  
     * приложения.
     * 
     * Пример, установка псевдонима:
     * ```php
     * Gm::setAlias('@serviceAlias', $this->property);
     * ```
     * 
     * Этот метод вызывается в конце конструктора после инициализации службы  
     * заданной конфигурацией.
     * 
     * @return void
     */
    public function initVariables(): void
    {
    }

    /**
     * Инициализация сервиса приложением.
     * 
     * @see \Gm\Mvc\Application::initServices()
     * 
     * @param \Gm\Mvc\Application $app Приложение.
     * 
     * @return void
     */
    public function bootstrap(\Gm\Mvc\Application $app): void
    {
    }

    /**
     * Проверяет, находится ли служба в автозагрузке приложения.
     * 
     * Выполнение приложением {@see Service::bootstrap()}.
     * 
     * @return bool
     */
    public function inBootstrap(): bool
    {
        /** @var null|bool $has */
        static $has;

        if (!isset($has)) {
            $has = Gm::$app->services->hasBootstrap($this->getObjectName());
        }
        return $has;
    }

    /**
     * Возвращает параметры конфигурации из унифицированного конфигуратора.
     * 
     * @return array
     */
    public function getUnifiedConfig(): array
    {
        return (array) Gm::$app->unifiedConfig->get($this->getObjectName());
    }
}
