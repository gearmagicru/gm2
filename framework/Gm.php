<?php
/**
 * GM Framework.
 * 
 * @link https://apps.gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

use Gm\Theme\Theme;
use Gm\Mvc\Application;
use Gm\Mvc\Module\BaseModule;
use Gm\View\ViewManager;
use Gm\User\UserIdentity;
use Gm\Config\BaseConfig;
use Gm\Session\Container;
use Gm\Stdlib\BaseObject;
use Gm\Exception\CreateObjectException;
use Gm\ServiceManager\ServiceManager;
use Composer\Autoload\ClassLoader;

/**
 * Gm - вспомогательный класс для GM Framework.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm
 * @since 2.0
 */
class Gm
{
    /**
     * @var string Имя фреймворка.
     */
    public const NAME = 'GM';

    /**
     * @var string Номер версии фреймоврка.
     */
    public const VERSION_NUMBER = '2.0';

    /**
     * Приложение.
     *
     * @var Application
     */
    public static Application $app;

    /**
     * Менеджера служб.
     *
     * @var ServiceManager
     */
    public static ServiceManager $services;

    /**
     * Загрузчик.
     * 
     * ClassLoader реализует загрузчик классов PSR-0, PSR-4 и classmap.
     *
     * @var ClassLoader
     */
    public static ClassLoader $loader;

    /**
     * Псевдонимы.
     * 
     * @see Gm::getAlias()
     * 
     * @var array<string, string>
     */
    public static array $aliases = [];

    /**
     * Менеджер представлений.
     *
     * @var ViewManager|null
     */
    protected static ?ViewManager $viewManager;

    /**
     * Включена ли запись отладочной информации.
     * 
     * @see Gm::useDebugLogging()
     * 
     * @var bool
     */
    protected static bool $useDebugLogging;

    /**
     * Контейнер объектов менеджера модулей и расширений.
     * 
     * @var array<string, object>
     */
    protected static array $container = [];

    /**
     * Порядковый номер, который при получении увеличивается на единицу.
     * 
     * Можно использовать, как уникальный идентификатор в пределах вызова. 
     * 
     * @see Gm::index()
     * 
     * @var int
     */
    protected static int $index = 1;

    /**
     * Возвращает значение псевдонима (с разбивкой).
     * 
     * @param string $alias Название псевдонима.
     * @param bool $throwException Создание исключения если псевдоним не найден.
     * 
     * @return false|string Значение `false`, если значение псевдонима неизвестно.
     * 
     * @throws InvalidArgumentException
     */
    public static function getAlias(string $alias, bool $throwException = false): false|string
    {
        if (strncmp($alias, '@', 1)) {
            return $alias;
        }

        if (isset(static::$aliases[$alias])) {
            return static::$aliases[$alias];
        }

        $pos = strpos($alias, '/');
        $prefix = $pos === false ? $alias : substr($alias, 0, $pos);
        if (isset(static::$aliases[$prefix])) {
            $result = $pos === false ? static::$aliases[$prefix] : static::$aliases[$prefix] . substr($alias, $pos);
            return static::$aliases[$alias] = $result;
        }

        if ($throwException) {
            throw new \InvalidArgumentException(
                sprintf('Invalid path alias: %s', $alias)
            );
        }
        return false;
    }

    /**
     * Устанавливает значение псевдониму.
     * 
     * @param string $alias Имя псевдонима.
     * @param string $path Значение псевдонима.
     * 
     * @return void
     */
    public static function setAlias(string $alias, string $path): void
    {
        if (strncmp($alias, '@', 1)) {
            $alias = '@' . $alias;
        }
        static::$aliases[$alias] = $path;
    }

    /**
     * Возвращает значение псевдонима.
     * 
     * @param string $alias Имя псевдонима.
     * @param null|string $path Добавляет к значению псевдонима.
     * 
     * @return null|string Значение '', если значение псевдонима неизвестно.
     */
    public static function alias(string $alias, ?string $path = null): ?string
    {
        if (strncmp($alias, '@', 1)) {
            return $alias;
        }
        if (isset(static::$aliases[$alias]))
            $prefix = static::$aliases[$alias];
        else
            $prefix = '';
        if ($path !== null) {
            $prefix .= $path;
        }
        return $prefix;
    }

    /**
     * Возвращает порядковый номер, который при получении увеличивается на единицу.
     * 
     * @return int
     */
    public static function index(): int
    {
        return self::$index++;
    }

    /**
     * Шифровать имена всех псевдонимов.
     * 
     * Каждое имя псевдонима имеет вид: "{name}".
     * 
     * @return array<string, string> Псевдонимы с их значениями в виде пар "ключ - значение".
     */
    public static function encodeAliases(): array
    {
        static $aliases;

        if ($aliases === null) {
            foreach(static::$aliases as $alias => $path) {
                $aliases['{' . $alias . '}'] = $path;
            }
        }
        return $aliases;
    }

    /**
     * Возвращает контент шорткода.
     * 
     * @param string $name Название шорткода.
     * @param array<string, mixed> $attributes Атрибуты шорткода.
     * 
     * @return string
     */
    public static function shortcode(string $codeName, array $attributes = []): string
    {
        return self::$app->shortcodes->getContent($codeName, $attributes);
    }

    /**
     * Регистрирует шорткод.
     * 
     * Прямая регистрация без указания модуля, которому должен принадлежать шорткод.
     * 
     * @param string $codeName Имя шорткода. Если был зарегистрирован ранее, будет замена.
     * @param mixed $func Функция обрабатывающая шорткод.
     *    Может иметь вид:
     *    - `'func_name'`
     *    - `['Class', 'func_name']`
     *    - `function (array $attributes = []) {...}`
     * 
     * @return \Gm\Shortcode\ShortcodeManager Менеджер шорткодов.
     */
    public static function addShortcode(string $codeName, mixed $func)
    {
        return self::$app->shortcodes->add($codeName, $func);
    }

    /**
     * Отменяет регистрацию шорткода.
     * 
     * @param string $codeName Имя шорткода.
     * 
     * @return \Gm\Shortcode\ShortcodeManager Менеджер шорткодов.
     */
    public static function removeShortcode(string $codeName)
    {
        return self::$app->shortcodes->remove($codeName);
    }

    /**
     * Возвращает модуль по указанному идентификатору.
     * 
     * @param string $id Идентификатор модуля, например 'gm.be.articles'.
     * @param bool $throwException Если значение `true`, будет исключение  при не 
     *     успешном создании модуля (по умолчанию `true`).
     * @param array<string, mixed> $params Параметры модуля передаваемые в конструктор 
     *     (по умолчанию []).
     * 
     * @return null|BaseModule Если значение `null`, то невозможно создать модуль с 
     *     указанным идентификатором.
     * 
     * @throws \Gm\ModuleManager\Exception\ModuleNotFoundException Модуль с указанным 
     *     идентификатором не существует.
     */
    public static function getModule(string $id, array $params = [], bool $throwException = true): ?BaseModule
    {
        return self::$app->modules->get($id, $params, $throwException);
    }

    /**
     * Возвращает текущий модуль приложения.
     * 
     * @return BaseModule|null Значение `null`, если модуль приложения ещё не создан.
     */
    public static function module(): ?BaseModule
    {
        return isset(self::$app) ? self::$app->module : null;
    }

    /**
     * Создаёт модуль по указанному идентификатору.
     * 
     * @param string $id Идентификатор модуля, например 'gm.be.articles'.
     * @param array<string, mixed> $params Параметры модуля передаваемые в конструктор 
     *     (по умолчанию []).
     * 
     * @return null|BaseModule Значение `null`, то невозможно создать модуль с 
     *     указанным идентификатором.
     * 
     * @throws \Gm\ModuleManager\Exception\ModuleNotFoundException Модуль с указанным 
     *     идентификатором не существует.
     */
    public static function createModule(string $id, array $params = []): ?BaseModule
    {
        return self::$app->modules->create($id, $params);
    }

    /**
     * Возвращает текущую кодировку символов в HTML.
     * 
     * @return string Текущая кодировка символов в HTML.
     */
    public static function charset(string $default = 'UTF-8'): string
    {
        return isset(self::$app) ? self::$app->charset : $default;
    }

    /**
     * Возвращает менеджер представлений.
     * 
     * @return null|\Gm\View\ViewManager Значение `null` если невозможно создать 
     *     менеджер, иначе менеджер представлений.
     */
    public static function viewManager(): ?ViewManager
    {
        if (!isset(self::$viewManager)) {
            self::$viewManager = self::$app->module?->viewManager;
        }
        return self::$viewManager;
    }

    /**
     * Перевод (локализация) сообщения.
     * 
     * @param string $category Имя категории сообщений, например: 'app', 'backend'.
     *     Категория может быть именем источника:
     *         - '@date': форматирование даты {@see \Gm\I18n\Source\DateSource};
     *         - '@message': форматирование сообщения {@see \Gm\I18n\Source\MessageSource};
     * @param string|array<string> $message Текст сообщения (сообщений).
     * @param array<string, string> $params Параметры перевода.
     * @param string $locale Код локали.
     * 
     * @return string|array Локализация сообщения или сообщений.
     */
    public static function t(string $category, string|array $message, array $params = [], string $locale = ''): string|array
    {
        if (isset(self::$app->translator))
            return self::$app->translator->translate($category, $message, $params, $locale);
        else
            return $message;
    }

    /**
     * Возвращает параметры конфигурации (службы, объекта) по указанному имени 
     * (службы, объекта) из Унифицированного конфигуратора.
     * 
     * Доступ к Унифицированному конфигуратору имеет вид: `Gm::$app->unifiedConfig`.
     * 
     * @param string|object $name Имя службы или объект.
     * 
     * @return mixed Значение `null` если в Унифицированном конфигураторе параметры 
     *     отсутствуют.
     */
    public static function getUnified($name): mixed
    {
        if (is_object($name)) {
            if ($name instanceof \Gm\Stdlib\Service) {
                $name = $name->getObjectName();
            }
        }
        return self::$app->unifiedConfig->get($name, null);
    }

    /**
     * Настраивает объект с начальными значениями свойств.
     * 
     * @param object $object Объект настройки.
     * @param array<string, mixed> $properties Начальные значения свойств в виде пар "имя - значение".
     *     Свойства могут содержать начальные значения для создания кофигуратора объекта.
     * @param bool $useUnifiedConfig Использовать параметры Унифицированного конфигуратора
     *     (по умолчанию `true`).
     * 
     * @return mixed Объект настройки.
     */
    public static function configure($object, array $properties, bool $useUnifiedConfig = false): mixed
    {
        // создание конфигуратора если указано в параметрах конфигурации
        if (isset($properties['config'])) {
            $propConfig = $properties['config'];
            if (is_array($propConfig)) {
                // название конфигуратора
                $name = $propConfig['name'] ?? 'config';
                // deprecated PHP 8.2 (creation of dynamic property)
                @$object->$name = self::createConfig($propConfig);
                unset($properties['config']);
            }
        }
        $unifiedProperties = $useUnifiedConfig ? self::getUnified($object) : null;
        if ($properties) {
            if ($unifiedProperties)
                $properties = array_merge($properties, $unifiedProperties);
        } else
        if ($unifiedProperties) {
            $properties = $unifiedProperties;
        }
        if ($properties) {
            foreach ($properties as $name => $value) {
                // deprecated PHP 8.2 (creation of dynamic property)
                @$object->$name = $value;
            }
        }
        return $object;
    }

    /**
     * Настраивает свойства указанного объекта согласно параметрам конфигурации
     * Унифицированного конфигуратора.
     * 
     * @param mixed $object Объект.
     * 
     * @return mixed Указанный объект.
     */
    public static function unifiedConfigure(mixed $object): mixed
    {
        $properties = self::getUnified($object);
        if ($properties) {
            foreach ($properties as $name => $value) {
                // deprecated PHP 8.2 (creation of dynamic property)
                @$object->$name = $value;
            }
        }
        return $object;
    }

    /**
     * Создаёт конфигуратор по указанным параметрам.
     * 
     * @param array<string, mixed> $params Параметры конфигуратора.
     * 
     * @return BaseConfig Конфигуратор с указанными параметрами.
     */
    public static function createConfig(array $params): BaseConfig
    {
        return self::$services->createAs(
            $params['class'] ?? 'config',
            [
                $params['filename'] ?? null,
                $params['useSerialize'] ?? false
            ]
        );
    }

    /**
     * Создаёт объект.
     * 
     * @see \Gm\ServiceManager\AbstractManager::createAs()
     * 
     * @param array<string, mixed> $params Параметры объекта в виде аргументов.
     * 
     * @return mixed Объект.
     */
    public static function createObject(...$params): mixed
    {
        /**
         * @var string $invokeName имя службы (псевдоним) или имя класса
         * @var array<string, mixed> $construct аргументы конструктора 
         * @var array<string, mixed> $config конфигурация класса
         */
        list($invokeName, $arguments, $config) = static::$services->normalizeParams($params);
        return static::$services->createAs($invokeName, $arguments, $config);
    }

    /**
     * Проверяет, был ли создан ранее объект по указанному классу.
     * 
     * @see \Gm\ServiceManager\AbstractManager::has()
     * 
     * @param string $invokeName Имя класса.
     * 
     * @return bool Значение `true`, если объект был создан ранее по указанному классу.
     */
    public static function hasObject(string $invokeName): bool
    {
        return self::$services->has($invokeName);
    }

    /**
     * Проверяет, был ли пользователь авторизован на указанной стороне.
     * 
     * @param null|int $side Если значение `null`, проверяет, авторизован ли пользователь. 
     *     Если значение имеет:
     *     - `FRONTEND_SIDE_INDEX`, пользователь авторизован на стороне frontend;
     *     - `BACKEND_SIDE_INDEX`, пользователь авторизован на стороне backend.
     * 
     * @return bool Значение `true`, если пользователь авторизован на указанной стороне.
     */
    public static function hasUserIdentity(int $side = null): bool
    {
        static $userSide;

        if ($userSide === null) {
            if (self::$app->user->hasIdentity()) {
                $userSide = self::$app->user->getIdentity()->getSide();
            } else
                $userSide = false;
        }
        return $side === null ? $userSide !== false : ($side === $userSide);
    }

    /**
     * Возвращает текущую тему приложения.
     * 
     * @return Theme|null Текущая тема приложения.
     */
    public static function theme(): ?Theme
    {
        return isset(self::$app) ? self::$app->theme : null;
    }

    /**
     * Возвращает идентификацию пользователя.
     * 
     * @see \Gm\User\UserIdentity
     * 
     * @return UserIdentity Идентификация пользователя.
     */
    public static function userIdentity(): UserIdentity
    {
        static $identity;

        if ($identity === null) {
            $identity  = self::$app->user->getIdentity();
        }
        return $identity; 
    }

    /**
     * Возвращает строку, представляющую текущую версию фреймворка.
     * 
     * @return string Версия фреймворка.
     */
    public static function getVersion(): string
    {
        return self::VERSION_NUMBER;
    }

    /**
     * Возвращает строку, представляющую имя фреймворка.
     * 
     * @param string $suffix Суффикс имени (по умолчанию `null`).
     * 
     * @return string Имя фреймворка.
     */
    public static function getName(string $suffix = null): string
    {
        return self::NAME . ($suffix === null ? '' : $suffix);
    }

    /**
     * Возвращает абсолютный путь для указанной директории или файла.
     * 
     * @param string $path Директория или файл.
     * @param null|string $basePath Базовый (абсолютный) путь, который будет добавлен к 
     *     указанной директории или файлу. Если значение `null`, будет добавлен базовый (абсолютный) 
     *     путь приложения (по умолчанию `null`).
     * 
     * @return false|string Значение `false`, если указанная директория или файл не существует.
     */
    public static function getSafePath(string $path, string $basePath = null): false|string
    {
        // если указан символ "@"
        if (strncmp($path, '@', 1) === 0) {
            return false;
        }

        $path = ltrim($path, DS);

        if ($basePath === null) {
            $basePath = static::$aliases['@home'] ?? BASE_PATH;
        }
        $path = $basePath . DS . $path;
        return file_exists($path) ? $path : false;
    }

    /**
     * Очищает (стерает) буфер вывода на всех уровнях вложенности и отключает буферизацию 
     * вывода.
     * 
     * @return void
     */
    public static function cleanOutputBuffer(): void
    {
        $level = ob_get_level();
        for ($level; $level > 0; --$level) {
            if (!@ob_end_clean()) {
                ob_clean();
            }
        }
    }

    /**
     * Запись сообщения службой Логгера с приоритетом "ERROR" (ошибка).
     * 
     * @see \Gm\Log\Logger::error()
     * 
     * @param string|array $message Сообщение.
     * @param array $extra Дополнительные параметры сообщения.
     * @param string $target Имя цели (по умолчанию 'application').
     * 
     * @return void
     */
    public static function error(array|string $message, array $extra = [], string $target = 'application'): void
    {
        if (self::$app) {
            self::$app->logger->error($message, $extra, null, $target);
        }
    }

    /**
     * Запись сообщения службой Логгера с приоритетом "WARNING" (предупреждение).
     * 
     * @see \Gm\Log\Logger::warning()
     * 
     * @param string|array $message Сообщение.
     * @param array $extra Дополнительные параметры сообщения.
     * @param string $target Имя цели (по умолчанию 'application').
     * 
     * @return void
     */
    public static function warning(string $message, array $extra = [], string $target = 'application'): void
    {
        if (isset(self::$app)) {
            self::$app->logger->warning($message, $extra, null, $target);
        }
    }

    /**
     * Запись сообщения службой Логгера с приоритетом "NOTICE" (уведомление).
     * 
     * @see \Gm\Log\Logger::notice()
     * 
     * @param string|array $message Сообщение.
     * @param array $extra Дополнительные параметры сообщения.
     * @param string $target Имя цели (по умолчанию 'application').
     * 
     * @return void
     */
    public static function notice(string $message, array $extra = [], string $target = 'application'): void
    {
        if (isset(self::$app)) {
            self::$app->logger->notice($message, $extra, null, $target);
        }
    }

    /**
     * Запись сообщения службой Логгера с приоритетом "DEBUG" (отладка).
     * 
     * @param string $message Сообщение.
     * @param array<string, mixed> $extra Дополнительные параметры сообщения.
     * @param string|null $category Имя категории сообщения (по умолчанию 'debug').
     * @param string $target Имя цели (по умолчанию 'debug').
     * 
     * @return void
     */
    public static function debug(string $message, array $extra = [], ?string $category = 'debug', string $target = 'debug'): void
    {
        if (GM_DEBUG && isset(self::$app)) {
            self::$app->logger->debug($message, $extra, $category, $target);
        }
    }

    /**
     * Запись сообщения службой Логгера с приоритетом "DEBUG" (отладка) для почты.
     * 
     * @param string $message Сообщение.
     * @param array<string, mixed> $extra Дополнительные параметры сообщения.
     * @param string|null $category Имя категории сообщения (по умолчанию 'debug').
     * @param string $target Имя цели (по умолчанию 'debug').
     * 
     * @return void
     */
    public static function mailProfiling(string $message, array $extra = [], ?string $category = 'mail', string $target = 'debug'): void
    {
        if (GM_DEBUG && isset(self::$app)) {
            self::$app->logger->mailProfiling($message, $extra, $category, $target);
        }
    }

    /**
     * Отправляет письмо.
     * 
     * Для отправки письма применяется служба Почты с адаптером по умолчанию.
     * 
     * @param array<string, mixed> $options Параметры письма.
     * @param bool $autocomplete Если значение `true`, то автоматически заполнит 
     *    определённые параметры ("replyTo", "from") письма (по умолчанию `false`).
     * 
     * @return bool|string Значение `true`, если письмо успешно отправлено, иначе 
     *     сообщение об ошибке.
     */
    public static function sendMail(array $options, bool $autocomplete = false): bool|string
    {
        /** @var \Gm\Mail\Mail $mail */
        $mail = self::$services->getAs('mail');
        // удаляем адаптер, если ранее был создан, чтобы каждый раз он 
        // инициализировался новыми параметрами $options
        $mail->resetAdapter();

        /** @var null|\Gm\Mail\Adapter\AbstractAdapter $adapter */
        $adapter = $mail->getAdapter();
        if ($adapter) {
            $adapter->setOptions($options, $autocomplete);
            if ($adapter->isError()) {
                // профилируем запрос, т.к. "send" не выполнен
                $adapter->profiling();
                return $adapter->getError();
            }
            return $adapter->send() ?: $adapter->getError();
        }
        return 'adapter not found';
    }

    /**
     * Проверяет, включена ли запись отладочной информации.
     * 
     * Если включена запись отладочной информации, это значит, что:
     *    - включен вывод ошибок `GM_DEBUG`;
     *    - включена служба Логгера {@see \Gm\Log\Logger::enabled()};
     *    - включен писатель отладочной информации в журнал.
     * 
     * @return bool Значение `true`, если была запись отладочной информации 
     *     в файл.
     */
    public static function useDebugLogging(): bool
    {
        if (!isset(self::$useDebugLogging)) {
            if (GM_DEBUG && self::$app->logger->enabled) {
                $writer = self::$app->logger->getWriter('debug');
                self::$useDebugLogging = $writer && $writer->enabled;
            } else
                self::$useDebugLogging = false;
        }
        return self::$useDebugLogging;
    }

    /**
     * Выполняет отладку переменной.
     *
     * @param mixed $var Переменная.
     * @param null|string $label Метка вывода.
     * @param bool $highlight Подсветить значение переменной (по умолчанию `true`).
     * @param bool $echo Если значение `true`, то будет вывод на печать. Иначе добавление 
     *     в стек отладки (по умолчанию `true`).
     * 
     * @return string Информация для вывода.
     */
    public static function dump($var, ?string $label = null, bool $highlight = true, bool $echo = true): string
    {
        return \Gm\Debug\Dumper::dump($var, $label, $highlight, $echo);
    }

    /**
     * Выводит сообщение в консоль браузера.
     * 
     * @param string $type Тип сообщения, например: 'log', 'error', 'warn', 'table', 'dir'.
     * @param string $message Сообщение.
     * @param mixed ...$vars Список объектов JavaScript для вывода.
     * 
     * @return void
     */
    public static function console(string $type, string $message, array $vars): void
    {
        self::$app->clientScript->js->console($type, $message, $vars);
    }

    /**
     * Устанавливает начальную точку профилирования запроса.
     * 
     * Точка будет установлена, только тогда, когда:
     *    - включен вывод ошибок `GM_DEBUG`;
     *    - включен режим профилирования ({@see \Gm\Log\Logger::isProfilingEnabled()}) в службе Логгера.
     * 
     * @param string $name Имя профиля.
     * @param string $category Имя категории к которой относится профилирование 
     *     (по умолчанию 'application').
     * 
     * @return array|null Значение `null`, если точка не установлена, иначе 
     *     параметры профиля запроса.
     */
    public static function beginProfile(string $name, string $category = 'application'): ?array
    {
        if (GM_DEBUG && self::$app->logger->isProfilingEnabled()) {
            return self::$app->logger->beginProfile($name, $category);
        }
        return null;
    }

    /**
     * Устанавливает конечнную точку профилирования запроса.
     * 
     * Точка будет установлена, только тогда, когда:
     *    - включен вывод ошибок `GM_DEBUG`;
     *    - включен режим профилирования ({@see \Gm\Log\Logger::isProfilingEnabled()}) в службе Логгера.
     * 
     * @param string $name Имя профиля (операнда).
     * @param string $message Сообщение (например, значение операнда).
     * @param array<string, mixed> $extra Дополнительные параметры (операнды или другая отладочная 
     *     информация) сообщения.
     * 
     * @return array|null Значение `null`, если точка не установлена, иначе 
     *     параметры профиля запроса.
     */
    public static function endProfile(string $name, string $message = '', array $extra = []): ?array
    {
        if (GM_DEBUG && self::$app->logger->isProfilingEnabled()) {
            return self::$app->logger->endProfile($name, $message, $extra);
        }
        return null;
    }

    /**
     * Возвращает информацию о запросе по указанному имени профиля.
     * 
     * Результат будет, только тогда, когда:
     *    - включен вывод ошибок `GM_DEBUG`;
     *    - включен режим профилирования ({@see \Gm\Log\Logger::isProfilingEnabled()}) 
     *    в службе Логгера.
     * 
     * @param string $name Имя профиля (операнда).
     * 
     * @return array|null Значение `null`, если вывод ошибок не включен или 
     *    не включен режим профилирования в службе Логгера. Иначе информацию о запросе.
     */
    public static function getProfiling(string $name): ?array
    {
        if (GM_DEBUG && self::$app->logger->isProfilingEnabled()) {
            return self::$app->logger->getProfiling($name);
        }
        return null;
    }

    /**
     * Рендер контента виджет по указанному идентификатору.
     * 
     * @param string $id Идентификатор виджета, например "gm.wd.article".
     * @param array<string, mixed> $settings Параметры настроек виджета. Если виджет 
     *     имеет файл конфигурации настроек, то указанные параметры будут заменены ими.
     * @param bool $render Если значение `true`, выводить контент виджета, иначе, 
     *     экземпляр класса виджета (по умолчанию `true`).
     * 
     * @return null|string|\Gm\View\Widget Значение `null`, если в параметрах 
     *     конфигурации установлено `enabled = false`.
     */
    public static function widget(string $id, array $settings = [], bool $render = true)
    {
         $widget = self::$app->widgets->createWidget($id, $settings);
         if ($render)
            return $widget ? $widget->render() : '';
         else
            return $widget;
    }

    /**
     * Определяет операционную систему под которую собран PHP.
     * 
     * @return array Операционная система под которую собран PHP.
     */
    public static function defineOs(): array
    {
        static $defineOs;

        if ($defineOs === null) {
            $possibleOs = ['CYGWIN_NT-5.1', 'Darwin', 'FreeBSD', 'HP-UX', 'IRIX64', 'Linux', 'NetBSD', 'OpenBSD', 'SunOS', 'Unix', 'WIN32', 'WINNT', 'Windows'];
            foreach($possibleOs as $os) {
                $defineOs[$os] = PHP_OS === $os;
            }
            // исключительно для windows
            if (!$defineOs['Windows']) {
                $defineOs['Windows'] = strtolower(substr(PHP_OS, 0, 3)) === 'win';
            }
        }
        return $defineOs;
    }

    /**
     * Определяет, является ли операционная система - Windows, под которую собран PHP.
     * 
     * @return bool Значение `true` если операционная система Windows.
     */
    public static function isWindowsOs(): bool
    {
        return self::defineOs()['Windows'];
    }

    /**
     * Определяет, является ли операционная система - Linux, под которую собран PHP.
     * 
     * @return bool Значение `true` если операционная система Linux.
     */
    public static function isLinuxOs(): bool
    {
        return self::defineOs()['Linux'];
    }

    /**
     * Определяет, является ли операционная система - Unix, под которую собран PHP.
     * 
     * @return bool начение `true` если операционная система Unix.
     */
    public static function isUnixOs(): bool
    {
        return self::defineOs()['Unix'];
    }

    /**
     * Временное хранение контейнера данных в сессии пользователя.
     * 
     * @see Gm::tempPut()
     * 
     * @var Container
     */
    protected static Container $temp;

    /**
     * Устанавливает значение временному контейнеру данных (сессии).
     * 
     * @param mixed $key Ключ значения временного контейнера данных.
     * @param mixed $value Значение.
     * 
     * @return void
     */
    public static function tempPut(mixed $key, mixed $value): void
    {
        if (!isset(self::$temp)) {
            self::$temp = new Container('Gm_Temp');
        }
        self::$temp->set($key, $value);
    }

    /**
     * Возвращает значение из временного контейнера данных (сессии).
     * 
     * @param mixed $key Ключ значения временного контейнера данных.
     * @param mixed $default Значение по умолчанию (по умолчанию `null`).
     * 
     * @return mixed Значение аргумента `$default` если ключ не существует.
     */
    public static function tempGet(mixed $key, mixed $default = null): mixed
    {
        if (!isset(self::$temp)) {
            self::$temp = new Container('Gm_Temp');
        }
        if (is_callable($default)) {
            $value = self::$temp->getValue($key, null);
            if ($value === null) {
                $value = $default();
                self::$temp->set($key, $value);
            }
            return $value;
        }
        return self::$temp->getValue($key, $default);
    }

    /**
     * Проверяет, активна ли сессия.
     * 
     * В отличии от {@see \Gm\Session\Session::isActive()} не требует создания экземпляра 
     * класса сессии. Т.к. при создании, есть вероятность старта {@see \Gm\Session\Session::$autoOpen} 
     * сессии, что приводит к бессмысленной проверки активности.
     * 
     * @return bool Если значение `true`, то сессия активна.
     */
    public static function isActiveSession(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Возвращает объект (модель данных, и т.п.) принадлежащих расширению модуля.
     * 
     * @see Gm\ModuleManager\BaseManager::getObject()
     * 
     * @param string $name Короткое имя класса объекта, например: 'Model\FooBar', 
     *     'Controller\FooBar'.
     * @param string $id Идентификатор расширения модуля или название его пространства имён, 
     *     например: 'gm.foobar' '\Gm\FooBar'.
     * @param array $config Параметры объекта (модель данных, и т.п.), которые будут 
     *     использоваться для инициализации его свойств.
     * 
     * @return mixed
     * 
     * @throws CreateObjectException Ошибка создания объекта.
     */
    public static function getEObject(string $name, string $id, array $config = []): mixed
    {
        $objectId = $id . $name;
        if (isset(static::$container[$objectId])) return static::$container[$objectId];

        /** @var BaseObject|null $model */
        $model = static::$app->extensions->getObject($name, $id, $config);
        if ($model === null) {
            throw new CreateObjectException(
                static::t('app', 'Could not defined data model "{0}"', [$id . '::' . 'Model' . NS . $name])
            );
        }
        return static::$container[$objectId] = $model;
    }

    /**
     * Возвращает объект (модель данных, и т.п.) принадлежащих модулю.
     * 
     * @see Gm\ModuleManager\BaseManager::getObject()
     * 
     * @param string $name Короткое имя класса объекта, например: 'Model\FooBar', 
     *     'Controller\FooBar'.
     * @param string $id Идентификатор модуля или название его пространства имён, 
     *     например: 'gm.foobar' '\Gm\FooBar'.
     * @param array $config Параметры объекта (модель данных, и т.п.), которые будут 
     *     использоваться для инициализации его свойств.
     * 
     * @return mixed
     * 
     * @throws CreateObjectException Ошибка создания объекта.
     */
    public static function getMObject(string $name, string $id, array $config = []): mixed
    {
        $objectId = $id . $name;
        if (isset(static::$container[$objectId])) return static::$container[$objectId];

        /** @var BaseObject|null $model */
        $model = static::$app->modules->getObject($name, $id, $config);
        if ($model === null) {
            throw new CreateObjectException(
                static::t('app', 'Could not defined data model "{0}"', [$id . '::' . 'Model' . NS . $name])
            );
        }
        return static::$container[$objectId] = $model;
    }

    /**
     * Возвращает модель данных расширения модуля.
     * 
     * @see Gm\ModuleManager\BaseManager::getModel() 
     * 
     * @param string $name Короткое имя класса модели данных, например: 'FooBar', 'Foo\Bar'.
     * @param string $id Идентификатор расширения модуля или название его пространства имён, 
     *     например: 'gm.foobar' '\Gm\FooBar'.
     * @param array $config Параметры модели в виде пар "имя - значение", которые 
     *     будут использоваться для инициализации ёё свойств.
     * 
     * @return mixed
     * 
     * @throws CreateObjectException Ошибка создания модели данных.
     */
    public static function getEModel(string $name, string $id, array $config = []): mixed
    {
        return static::getEObject('Model' . NS . $name, $id, $config);
    }

    /**
     * Возвращает модель данных модуля.
     * 
     * @see Gm\ModuleManager\BaseManager::getModel() 
     * 
     * @param string $name Короткое имя класса модели данных, например: 'FooBar', 'Foo\Bar'.
     * @param string $id Идентификатор модуля или название его пространства имён, 
     *     например: 'gm.foobar' '\Gm\FooBar'.
     * @param array $config Параметры модели в виде пар "имя - значение", которые 
     *     будут использоваться для инициализации ёё свойств.
     * 
     * @return mixed
     * 
     * @throws CreateObjectException Ошибка создания модели данных.
     */
    public static function getMModel(string $name, string $id, array $config = []): mixed
    {
        return static::getMObject('Model' . NS . $name, $id, $config);
    }

    /**
     * Возвращает идентификатор термина по указанному названию.
     * 
     * @param string $name Название термина.
     * @param string|null $componentId Идентификатор компонента, которому принадлежит 
     *     термин. Если значение `null`, то идентификатор текущего модуля (по умолчанию `null`).
     * 
     * @return null|int Идентификатор термина при успешном запросе, иначе `null`.
     */
    public static function getTermId(string $name, ?string $componentId = null): ?int
    {
        $termId = self::$app->terms->getId($name, $componentId);
        if ($termId === null) {
            Gm::error('The term "' . $name . '" for component "' . $componentId . '" does not exist.');
        }
        return $termId;
    }
}
