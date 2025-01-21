<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\View\Helper;

use Gm;
use Gm\View\ClientScript;

/**
 * Вспомогательный класс формирования URL-адресов ресурсов HTML-страницы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\View\Helper
 * @since 2.0
 */
class Link implements HelperInterface
{
    /**
     * Массив линков.
     * 
     * @var array
     */
    protected array $links = [];

    /**
     * Помощник формирования favorite icon.
     * 
     * @see Link::appendFavicon()
     * 
     * @var Favicon
     */
    protected Favicon $favicon;

    /**
     * Базовый (абсолютный) URL к темам
     * имеет вид: "<абсолютный URL приложения/> <локальный путь к темам/>".
     * 
     * @see Gm\Theme\Theme::$baseUrl
     * 
     * @var string
     */
    public string $themeUrl = '';

    /**
     * Вывод комментариев.
     * 
     * @var bool
     */
    public bool $renderComments = true;

    /**
     * Конструктор класса.
     *
     * @return void
     */
    public function __construct()
    {
        $this->themeUrl = Gm::$app->theme->url;
    }

    /**
     * Добавление линка.
     *
     * @param string $id Идентификатор линка.
     * @param string $filename Название файла.
     * @param string $position Позиция на странице (по умолчанию 'head').
     * 
     * @return $this
     */
    public function setFile(string $id, string $filename, string $position = ClientScript::POS_HEAD): static
    {
        $this->files[$position] = array($id => ClientScript::defineSrc($this->themeUrl, $filename));
        return $this;
    }

    /**
     * Добавление favorite icon.
     *
     * @param array $options Параметры (по умолчанию `[]`).
     * 
     * @return $this
     */
    public function appendFavicon(array $options = []): static
    {
        if (!isset($this->favicon)) {
            $this->favicon = new Favicon($options);
        }
        return $this;
    }

    /**
     * Возвращение собранных линков ввиде HTML.
     * 
     * @param string $indent Отступ от левого края в символах (по умолчанию '').
     * 
     * @return string
     */
    public function render(string $indent = ''): string
    {
        $links = '';
        if ($this->renderComments && $this->favicon) {
            $links .= '<!-- ' . $this->comments['favicon'] . ' -->' . PHP_EOL . $indent;
            $links .= $this->favicon->render();
        }
        return $links;
    }
}
