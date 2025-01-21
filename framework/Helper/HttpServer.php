<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Helper;

/**
 * Вспомогательный класс HttpServer, определяет версию HTTP сервера.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Helper
 * @since 2.0
 */
class HttpServer
{
    /**
     * Информация о HTTP-сервере.
     * 
     * @see HttpServer::info()
     * 
     * @var false|array
     */
    protected static false|array $info;

    /**
     * Шаблоны имён HTTP-серверов.
     * 
     * @var array
     */
    protected static array $servers = [
        'Apache' => [
            'name'     => 'apache',
            'fullName' => 'Apache HTTP Server',
            'url'      => 'https://httpd.apache.org/',
            'pattern'  => 'apache'
        ],
        'NGINX' => [
            'name'     => 'nginx',
            'fullName' => 'NGINX',
            'url'      => 'http://nginx.org/',
            'icon'     => 'nginx',
            'pattern'  => 'nginx'
        ],
        'Apache Tomcat' => [
            'name'     => 'tomcat',
            'fullName' => 'Apache Tomcat',
            'url'      => 'https://tomcat.apache.org/',
            'pattern'  => 'tomcat'
        ],
        'Node' => [
            'name'     => 'node',
            'fullName' => 'Node.js',
            'url'      => 'https://nodejs.org/',
            'pattern'  => 'node'
        ],
        'IIS' => [
            'name'     => 'iis',
            'fullName' => 'Microsoft IIS (Internet Information Services)',
            'url'      => 'https://www.iis.net/',
            'pattern'  => 'iis'
        ]
    ];

    /**
     * Возвращает имя HTTP-сервера.
     * 
     * @return false|array
     */
    public static function info(): false|array
    {
        if (isset(self::$info)) {
            return self::$info;
        }

        $server = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : false;
        if ($server === false) {
            return self::$info = false;
        }

        $search = strtolower($server);
        foreach (self::$servers as $name => $info) {
            if (false !== strpos($search, $info['pattern'])) {
                return self::$info = $info;
            }
        }
        return self::$info = false;
    }

    /**
     * Если HTTP-сервер Apache.
     * 
     * @return bool
     */
    public static function isApache(): bool
    {
        $info = self::info();
        if ($info === false) {
            return false;
        }
        return $info['name'] === 'apache';
    }

    /**
     * Если HTTP-сервер NGINX.
     * 
     * @return bool
     */
    public static function isNginx(): bool
    {
        $info = self::info();
        if ($info === false) {
            return false;
        }
        return $info['name'] === 'nginx';
    }

    /**
     * Если HTTP-сервер IIS.
     * 
     * @return bool
     */
    public static function isIIS(): bool
    {
        $info = self::info();
        if ($info === false) {
            return false;
        }
        return $info['name'] === 'iis';
    }

    /**
     * Возвращает версию HTTP-сервера.
     * 
     * @return false|string
     */
    public static function version(): false|string
    {
        if (self::isApache()) {
            if (function_exists('apache_get_version'))
                return apache_get_version();
        }
        return false;
    }

    /**
     * Возвращает подключенные модули HTTP-сервера.
     * 
     * @return false|array
     */
    public static function modules(): false|array
    {
        if (self::isApache()) {
            if (function_exists('apache_get_modules'))
                return apache_get_modules();
        }
        return false;
    }
}