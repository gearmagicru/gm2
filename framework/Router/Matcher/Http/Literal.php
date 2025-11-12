<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Router\Matcher\Http;

use Gm;

/**
 * Точное сопоставление маршрута.
 * 
 * Опции используемые для проверки и сопоставления маршрута:
 * - "method", метод запроса {@see BaseMatcher::$method}.
 * 
 * Пример:
 * ```php
 * // для маршрута "https://domain.com/foobar/feedback"
 * Gm::$app->router->match([
 *     'type'     => 'literal',
 *     'compare'  => 'route',
 *     'module'   => 'foo.bar.feedback',
 *     'route'    => 'foobar/feedback'
 * ]);
 * // результат: ['action' => 'index', 'controller' => 'index', ...].
 * ```
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Router\Matcher\Http
 * @since 2.0
 */
class Literal extends BaseMatcher
{
    /**
     * Метод сравнения.
     * 
     * Методы сравнения:
     * - 'uri', схема URI, например: 'foo/bar/filename.html', 'foo/bar', 'filename.html';
     * - 'route', маршрут запроса: 'foo/bar', 'foo';
     * - 'filename', имя файла в URL-адресе, например: 'foo/bar/filename.html', 'filename.html'.
     * 
     * @var string
     */
    protected string $compare = 'route';

    /**
     * {@inheritdoc}
     */
    public function defineOptions(array $options): void
    {
        parent::defineOptions($options);

        if (isset($options['compare'])) {
            $this->compare = $options['compare'];
        }
    }

    /**
     * {@inheritdoc}
     * 
     * @param null|string $route Cопоставляемый маршрут, например 'user/account' (по умолчанию `null`).
     */
    public function match(?string $route = null): mixed
    {
        if ($route === null) {
            // сравнение маршрута
            if ($this->compare === 'route')
                $route = Gm::$app->urlManager->route;
            else
            // сравнение URI схемы
            if ($this->compare === 'uri')
                $route = Gm::$app->urlManager->requestUri;
            else
            // сравнение файла
            if ($this->compare === 'filename')
                $route = Gm::$app->urlManager->filename;
        }

        // проверка принадлежности маршрута модулю
        if ($route !== $this->route) return false;

        // проверка метода запроса если он указан
        if ($this->method) {
            if (!Gm::$app->request->isMethod($this->method)) return null;
        }

        return [
            'baseRoute'  => $this->route,
            'namespace'  => $this->namespace,
            'module'     => $this->module,
            'controller' => $this->getDefaultController(),
            'action'     => $this->getDefaultAction()
        ];
    }
}
