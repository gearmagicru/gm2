<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Report;

use Gm;
use Gm\Stdlib\Service;

/**
 * Журнал записей (отчётности) полученный при возникновении исключения (ошибки) 
 * на стороне клиента с уведомлением администратору.
 * 
 * Report - это служба приложения, доступ к которой можно получить через `Gm::$app->report`.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Report
 * @since 2.0
 */
class Report extends Service
{
    protected $crypter;

    /**
     * @var string
     */
    public $name = 'report';

    /**
     * @var bool
     */
    public bool $enable = false;

    /**
     * @var array
     */
    public array $responseClass = [];

    /**
     * @var bool
     */
    public bool $backendOnly = false;

    /**
     * @var bool
     */
    public bool $authorizedUsersOnly = true;

    /**
     * @var bool
     */
    public bool $crypt = false;

    /**
     * @var bool
     */
    public bool $cryptClass = false;

    /**
     * @var string
     */
    public string $cryptKey = '';

    /**
     * Инициализация сервиса.
     * 
     * @return void
     */
    public function init(): void
    {
        $this->responseClass = (array) $this->responseClass;
    }

    /**
     * Проверяет, доступен ли журнал.
     * 
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enable;
    }

    /**
     * Проверяет, активен ли журнал для запроса пользователя.
     * 
     * @param \Gm\Http\Reponse $responseClass
     * 
     * @return bool
     */
    public function isActive($responseClass)
    {
        if (!in_array($responseClass, $this->responseClass)) {
            return false;
        }

        if ($this->backendOnly) {
            if (!Gm::$app->isBackend()) return false;
        }

        if ($this->authorizedUsersOnly) {
            if (!Gm::hasUserIdentity()) return false;
        }
        return true;
    }

    /**
     * Возвращает парамеры, связывающие название полей таблицы журнала.
     * 
     * @see bindLogParams()
     * 
     * @return array
     */
    public function getBindParams(): array
    {
        return [
            'userId'             => 'user_id',
            'userName'           => 'user_name',
            'userDetail'         => 'user_detail',
            'userPermission'     => 'user_permission',
            'userIpaddress'      => 'user_ipaddress',
            'moduleId'           => 'module_id',
            'moduleName'         => 'module_name',
            'controllerName'     => 'controller_name',
            'controllerAction'   => 'controller_action',
            'metaBrowser'        => 'meta_browser',
            'metaBrowserVersion' => 'meta_browser_version',
            'metaOs'             => 'meta_os',
            'metaOsVersion'      => 'meta_os_version',
            'requestUrl'         => 'request_url',
            'requestMethod'      => 'request_method',
            'requestCode'        => 'request_code',
            'querySql'           => 'query_sql',
            'queryId'            => 'query_id',
            'queryParams'        => 'query_params',
            'error'              => 'error',
            'errorCode'          => 'error_code',
            'errorParams'        => 'error_params',
            'success'            => 'success',
            'comment'            => 'comment',
            'date'               => 'date'
        ];
    }

    /**
     * Возвращает, результата название полей (таблицы журанала) с их значениями.
     * 
     * @param array $reportParams
     * 
     * @return array
     */
    public function bindLogParams(array $reportParams): array
    {
        $params = $this->getBindParams();
        $result = [];
        foreach ($params as $name => $field) {
            if (isset($reportParams[$name]))
                $result[$field] = $reportParams[$name];
        }
        return $result;
    }

    /**
     * Зашифровывает данные ключем {@see $cryptKey}.
     * 
     * @param mixed $data
     * 
     * @return string
     */
    public function encrypt($data)
    {
        $data = serialize($data);
        $crypter = $this->getCrypter();
        if ($crypter)
            $data = $crypter->encrypt($data, $this->cryptKey);
        else
            $data = base64_encode($data);
        return $this->addMask($data);
    }

    /**
     * Расшифровует данные ключем {@see $cryptKey}.
     * 
     * @param mixed $data
     * 
     * @return string
     */
    public function decrypt($data)
    {
        if (($strip = $this->stripMask($data)) === false)
            return $data;
        else
            $data = $strip;
        $crypter = $this->getCrypter();
        if ($crypter)
            $data = $crypter->decrypt($data, $this->cryptKey);
        else
            $data = base64_decode($data);
        return unserialize($data);
    }

    /**
     * Возвращает указатель на экземпляр класса шифрования.
     * 
     * @return object
     */
    public function getCrypter()
    {
        if ($this->crypter === null) {
            if (!$this->cryptClass)
                return null;
            $this->crypter = new $this->cryptClass();
        }
        return $this->crypter;
    }

    /**
     * Возвращает зашифрованные данные журнала.
     * 
     * @param string|array $params
     * 
     * @return string
     */
    public function create(string|array $params)
    {
        if (is_string($params)) {
            $params = ['error' => $params];
        }

        $params = array_merge($this->getDefaultParams(), $params);
        return $this->encrypt($params);
    }

    /**
     * @param string $string
     * 
     * @return string
     */
    public function addMask(string $string): string
    {
        return "<report>{$string}</report>";
    }

    /**
     * @param string $mask
     * 
     * @return string|false
     */
    public function stripMask(string $mask): string|false
    {
        if (preg_match_all('|<report>(.+)</report>|isU', $mask, $matches)) { 
            return $matches[1][0];
        }
        return false;
    }

    /**
     * Возвращает параметров журнала по умолчанию
     * 
     * @return array
     */
    public function getDefaultParams(): array
    {
        $module = Gm::$app->module;
        if ($module === null) {
            $controller = $moduleVer = null;
        } else {
            $controller = $module->controller();
            $moduleVer = $module->config->getConfigData('version');
            $language = Gm::$app->language->tag;
        }

        $user      = Gm::$app->user;
        $userStore = $user->getStorage()->all();

        if (isset($userStore['browser']))
            $browser = $userStore['browser'];
        else
            $browser = null;
        if (isset($userStore['os']))
            $os = $userStore['os'];
        else
            $os = null;
        return [
            'userId'         => $user->getId(),
            'userName'       => $user->getUsername(),
            'userDetail'     => isset($userStore['profile']['name']) ? $userStore['profile']['name'] : null,
            'userPermission' => $user->getBac()->permission(),
            'userIpaddress'  => $_SERVER['REMOTE_ADDR'],
            'moduleId'       => $module ? $module->id : null,
            'moduleName'     => $moduleVer ? $moduleVer['name'][$language][0] : '',
            'metaBrowser'    => $browser ? $browser['name'] : null,
            'metaBrowserVersion' => $browser ? $browser['version'] : null,
            'metaOs'           => $os ? $os['name'] : null,
            'metaOsVersion'    => $os ? $os['version'] : null,
            'requestUrl'       => Gm::alias('@route'),
            'requestMethod'    => $controller ? Gm::$app->request->getMethod() : null,
            'requestCode'      => 200,
            'controllerName'   => $controller ? ucfirst($controller->getShortClass()) : null,
            'controllerAction' => $controller ? $controller->action() : null,
            'success'          => false,
            'date'             => gmdate('Y-m-d H:i:s')
        ];
    }
}
