<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Http;

use Gm;
use Gm\Stdlib\Service;
use Gm\Exception;
use Gm\Helper\Str;

/**
 * Класс веб-запроса представлен в виде HTTP-запроса.
 * 
 * Доступ к экземпляру класса можно получить через `Gm::$app->request`.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Http
 * @since 2.0
 */
class Request extends Service
{
    /**
     * Параметр, который передаёт запросом GET значение свойства 
     * hash интерфейса URL (идентификатор фрагмента URL после символа «#»).
     * 
     * Добавляется в запрос, только с помощью JavaScript. Если имя параметра 
     * не указано, добавление в запросе не будет.
     * 
     * Пример: "/request#my_hash" => "/request?_hash=my_hash#my_hash"
     * 
     * @var string
     */
    public string $hashParam = '_hash';

    /**
     * Значение свойства hash интерфейса URL (идентификатор фрагмента 
     * URL после символа «#»).
     * 
     * @see Request::$hashParam
     * 
     * @var string
     */
    protected $hash;

    /**
     * Яявляется ли текущий запрос AJAX (XMLHttpRequest).
     * 
     * @see Request::isAjax()
     * 
     * @var bool
     */
    protected bool $isAjax;

    /**
     * Яявляется ли текущий запрос PJAX.
     * 
     * @see Request::IsPjax()
     * 
     * @var bool
     */
    protected bool $IsPjax;

    /**
     * Яявляется ли текущий запрос GJAX.
     * 
     * @see Request::IsGjax()
     * 
     * @var bool
     */
    protected bool $IsGjax;

    /**
     * Яявляется ли текущий запрос Adobe Flash или Flex.
     * 
     * @see Request::IsFlash()
     * 
     * @var bool
     */
    protected bool $IsFlash;

    /**
     * Запрос сделан с помощью метода POST.
     * 
     * @var bool
     */
    public bool $isPost = false;

    /**
     * Запрос сделан с помощью метода GET.
     * 
     * @var bool
     */
    public bool $isGet = false;

    /**
     * Запрос сделан с помощью метода PUT.
     * 
     * @var bool
     */
    public bool $isPut = false;

    /**
     * Запрос сделан с помощью метода OPTIONS.
     * 
     * @var bool
     */
    public bool $isOptions = false;

    /**
     * Запрос сделан с помощью метода HEAD.
     * 
     * @var bool
     */
    public bool $isHead = false;

    /**
     * Запрос сделан с помощью метода DELETE.
     * 
     * @var bool
     */
    public bool $isDelete = false;

    /**
     * Запрос сделан с помощью метода PATCH.
     * 
     * @var bool
     */
    public bool $isPatch = false;

    /**
     * Абсолютный путь к исполняемому скрипту.
     * 
     * @see setScriptFile()
     * @see getScriptFile()
     * 
     * @var string
     */
    protected string $scriptFile;

    /**
     * Путь к текущему исполняемому скрипту.
     * 
     * @see getScriptName()
     * 
     * @var string
     */
    protected string $scriptName;

    /**
     * Относительный URL-адрес исполняемого скрипта.
     * 
     * @see getScriptUrl()
     * 
     * @var string
     */
    protected string $scriptUrl;

    /**
     * Относительный URL-адрес исполняемого скрипта и абсолютный путь к нему.
     * 
     * @see Request::getScript()
     * 
     * @var array
     */
    protected array $script;

    /**
     * Заголовок запроса, определяющий в каком формате должен быть ответ.
     * 
     * @see Request::getResponseFormatHeader()
     * 
     * @var string
     */
    public string $responseFormatHeader = 'X-Response-Format';

    /**
     * Коллекция заголовков.
     * 
     * @var Headers
     */
    protected Headers $headers;

    /**
     * Метод текущего запроса.
     * 
     * @see Request::getMethod()
     * 
     * @var string
     */
    protected string $method;

    /**
     * Безопасные методы запроса.
     * 
     * Эти методы предназначены только для получения информации и не должны 
     * изменять состояние сервера.
     * 
     * @link https://datatracker.ietf.org/doc/html/rfc7231#section-4.2
     * 
     * @var array
     */
    protected array $safeMethods = ['GET', 'HEAD', 'OPTIONS', 'TRACE'];

    /**
     * Доступные методы запроса.
     * 
     * @var array
     */
    public array $allowedMethods = ['OPTIONS', 'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'TRACE', 'CONNECT'];

    /**
     * Включает проверку CSRF (подделка межсайтовых запросов).
     * 
     * Когда проверка CSRF включена, отправляемые запросы от клиента должны быть 
     * из этого же приложения. Если нет, будет исключение HTTP 400 .
     *
     * Для проверки CSRF необходимо, чтобы клиент принимал cookie.
     * Кроме того, чтобы использовать эту функцию, формы, отправленные с помощью 
     * метода POST, должны содержать скрытый ввод, имя которого указано в {@see Request::$csrfParamName}.
     * 
     * Для передачи HTTP-заголовков с CSRF токеном, необходимо добавить метатег CSRF 
     * на своей странице, используя:
     * ```php
     * Gm:$app->clientScript->meta->csrfTokenTag();
     * ```

     * @link https://ru.wikipedia.org/wiki/Межсайтовая_подделка_запроса
     * 
     * @var bool
     */
    public bool $enableCsrfValidation = true;

    /**
     * Параметры конфигурации для создания CSRF cookie.
     * 
     * Это свойство используется только тогда, когда {@see Request::$enableCsrfValidation}  
     * и {@see Request::enableCsrfCookie}} true. 

     * @var array
     */
    public array $csrfCookie = ['httpOnly' => true];

    /**
     * Время жизни CSRF cookie в минутах.
     * 
     * Если значение 0, значит cookie сессионные.
     * Это свойство устанавливается для {@see Request::$csrfCookie}.

     * @var int
     */
    public int $csrfCookieLifeTime = 0;

    /**
     * Имя токена cookie для хранения CSRF значения.
     * 
     * Если значение null, используется значение {@see Request::$csrfParam}.
     * Это свойство устанавливается для {@see Request::$csrfCookie}.

     * @var string
     */
    public string $csrfCookieName = 'xcsrf-token';

    /**
     * Имя токена сессии для хранения CSRF значения.
     * 
     * Если значение null, используется значение {@see Request::$csrfParam}.

     * @var string
     */
    public string $csrfSessionName = 'xcsrf-token';

    /**
     * Имя HTTP-заголовка для отправки CSRF токена.
     * 
     * @var string
     */
    public string $csrfHeaderName = 'csrf-token';

    /**
     * Имя токена формы для хранения CSRF значения.
     * 
     * @var string
     */
    public string $csrfParamName = '_csrf';

    /**
     * Значение токена CSRF, полученный из запроса пользователя или был 
     * сгенерирован.
     * 
     * @see Request::getCsrfToken()
     * 
     * @var string
     */
    protected string $csrfToken;

    /**
     * Имя токена cookie для хранения разметки значения.
     * 
     * @var string
     */
    public string $markupCookieName = 'markup-token';

    /**
     * Секретный ключ, используемый для проверки подлинности токена разметки.
     * 
     * @see Request::validateMarkupToken()
     * 
     * @var null|string
     */
    public string $markupValidationKey;

    /**
     * Использовать cookie для хранения токена CSRF.
     * 
     * Если значение true, токен CSRF будет храниться в cookie под именем 
     * {@see Request::$csrfCookieName} или {@see Request::$csrfParam}.
     * 
     * @var bool 
     */
    public bool $enableCsrfCookie = true;

    /**
     * Использовать сессию для хранения токена CSRF.
     * 
     * Если значение true, токен CSRF будет храниться в сессии под именем 
     * {@see Request::$csrfSessionName} или {@see Request::$csrfParam}.
     * Хранение токенов CSRF в сессии повышает безопасность, оно требует 
     * запуска сессии для каждой страницы, что снизит производительность.
     * 
     * @var bool 
     */
    public bool $enableCsrfSession = false;

    /**
     * Включает проверку подлинности cookie.
     * 
     * @see Request::loadCookies()
     * 
     * @var bool
     */
    public bool $enableCookieValidation = true;

    /**
     * Секретный ключ, используемый для проверки подлинности cookie.
     * 
     * @see Request::loadCookies()
     * 
     * @var string
     */
    public bool $cookieValidationKey;

    /**
     * Имена cookie, которые необходимо проверять.
     * 
     * Имеет формат:
     *     - `*`, все cookie;
     *     - `['name1', 'name2'...]`, массив имён cookie.
     * 
     * @see Request::loadCookies()
     * 
     * @var string|array
     */
    public string|array $cookieValidation;

    /**
     * Для каждого запроса создавать новый CSRF токен.
     * 
     * @see Request::getCsrfToken()
     * 
     * @var bool
     */
    public bool $regenerateCsrfToken = false;

    /**
     * Коллекция cookie.
     * 
     * @see Request::loadCookies()
     * 
     * @var CookieCollection
     */
    protected CookieCollection $cookies;

     /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        // определение метода запроса
        $this->defineMethod();
    }

    /**
     * Возвращает метод текущего запроса.
     * 
     * @return string Метод текущего запроса в верхнем регистре, такой как: GET, POST, HEAD, PUT, PATCH, DELETE.
     */
    public function getMethod(): string
    {
        if (!isset($this->method)) {
            if ($method = $this->getHeaders()->get('X-Http-Method-Override')) {
                $this->method = strtoupper($method);
            } else
            if (isset($_SERVER['REQUEST_METHOD'])) {
                $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
            } else
                $this->method = 'GET';
        }
        return $this->method;
    }

    /**
     * Проверка метода текущего запроса.
     * 
     * @param $method Имя метода.
     * 
     * @return bool Если true, метод $method совпал с методом запроса.
     */
    public function isMethod(string $method): bool
    {
        return $this->getMethod() === $method;
    }

    /**
     * Проверяет, является ли текущий метод запроса безопасным.
     * 
     * @return bool Если true, метод запроса безопасный.
     */
    public function isSafeMethod(): bool
    {
        static $safe;

        if ($safe === null) {
            $safe = in_array($this->getMethod(), $this->safeMethods, true);
        }
        return $safe;
    }

    /**
     * Определение текущего метода запроса.
     * 
     * В зависимости от метода запроса, такие атрибуты как: $isPost, $isOptions, $isHead, $isDelete, $isPatch, $isGet, $isPut 
     * будут иметь true.
     * 
     * @return $this
     */
    protected function defineMethod(): static
    {
        $isMethod = 'is' . ucfirst(strtolower($this->getMethod()));
        if (isset($this->$isMethod))
            $this->$isMethod = true;
        else
            $this->isGet = true;
        return $this;
    }

     /**
     * Установка значения POST параметра.
     * 
     * @param string $name Имя параметра.
     * @param mixed $value Значение параметра.
     *    Если значение не указано, параметр будет удален.
     * 
     * @return $this
     */
    public function setPost(string $name, mixed $value = null): static
    {
        if ($value === null)
            unset($_POST[$name]);
        else
            $_POST[$name] = $value;
        return $this;
    }

    /**
     * Возвращает значение POST параметра.
     * Если имя не указано, возвращает массив всех параметров POST.
     * 
     * @param array|string|null $name Имя или массив имен параметров POST.
     * @param mixed $default Значение по умолчанию, возвращаемое если параметр не существует.
     * @param mixed $type Тип возвращаемого значения (по умолчанию `null`). Если `null`, 
     *     приведение типа возвращаемого значения не будет. Допустимыми значениями:
     *     - 'boolean' или 'bool';
     *     - 'integer' или 'int';
     *     - 'float' или 'double';
     *     - 'string';
     *     - 'array';
     *     - 'object'.
     * 
     * @return mixed
     */
    public function getPost(array|string $name = null, mixed $default = null, string $type = null): mixed
    {
        if ($name === null) {
            return $_POST;
        }
        if (is_array($name)) {
            $result = [];
            foreach ($name as $key => $value) {
                // если нумерованный массив
                if (is_numeric($key)) {
                    $key = $value;
                }
                if (isset($_POST[$key])) {
                    $value = $_POST[$key];
                    if ($type) {
                        settype($value, $type);
                    }
                    $result[$key] = $value;
                } else
                    $result[$key] = $default;
            }
            return $result;
        } else {
            if (isset($_POST[$name])) {
                $value = $_POST[$name];
                if ($type) {
                    settype($value, $type);
                }
                return $value;
            } else
                return $default;
        }
    }

    /**
     * Возвращает значение GET параметра.
     * Если имя не указано, возвращает массив всех параметров GET.
     * 
     * @param array|string|null $name Имя или массив имен параметров GET.
     * @param mixed $default Значение по умолчанию, возвращаемое если параметр не существует.
     * @param string $type Тип возвращаемого значения (по умолчанию `null`). Если `null`, 
     *     приведение типа возвращаемого значения не будет. Допустимыми значениями:
     *     - 'boolean' или 'bool';
     *     - 'integer' или 'int';
     *     - 'float' или 'double';
     *     - 'string';
     *     - 'array';
     *     - 'object'.
     * 
     * @return mixed
     */
    public function getQuery(array|string $name = null, mixed $default = null, string $type = null): mixed
    {
        if ($name === null) {
            return $_GET;
        }

        if (is_array($name)) {
            $result = [];
            foreach ($name as $key => $value) {
                // если нумерованный массив
                if (is_numeric($key)) {
                    $key = $value;
                }
                if (isset($_GET[$key])) {
                    $value = $_GET[$key];
                    if ($type) {
                        settype($value, $type);
                    }
                    $result[$key] = $value;
                } else
                    $result[$key] = $default;
            }
            return $result;
        } else {
            if (isset($_GET[$name])) {
                $value = $_GET[$name];
                if ($type) {
                    settype($value, $type);
                }
                return $value;
            }
            return $default;
        }
    }

    /**
     * Проверка существования GET параметра.
     * Если имя не указано, проверяет существование параметров GET.
     * 
     * @return bool
     */
    public function hasQuery(string $name = null): bool
    {
        return $name === null ? !empty($_GET) : isset($_GET[$name]);
    }

    /**
     * Проверка существования GET параметра.
     * Если имя не указано, проверяет существование параметров GET.
     * 
     * @return bool
     */
    public function hasPost(string $name = null): bool
    {
        return $name === null ? !empty($_POST) : isset($_POST[$name]);
    }

     /**
     * Установка GET параметра.
     * 
     * @param string $name Имя пераметра.
     * @param mixed $value Значение параметра.
     *    Если значение не указано, параметр будет удален.
     * 
     * @return Request
     */
    public function setQuery(string $name, mixed $value = null): static
    {
        if ($value === null)
            unset($_GET[$name]);
        else
            $_GET[$name] = $value;
        return $this;
    }

    /**
     * Возвращает значение GET параметра.
     * Если имя не указано, возвращает массив всех параметров GET.
     * 
     * @param string|null $name Имя GET параметра.
     * @param mixed $default Значение по умолчанию, возвращаемое если параметр не существует.
     * 
     * @return mixed
     */
    public function get(?string $name, mixed $default = null): mixed
    {
        if ($name == null) {
            return $_GET;
        }
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    /**
     * Возвращает значение POST параметра.
     * Если имя не указано, возвращает массив всех параметров POST.
     * 
     * @param string|null $name Имя POST параметра.
     * @param mixed $default Значение по умолчанию, возвращаемое если параметр не существует.
     * 
     * @return mixed
     */
    public function post(?string $name, mixed $default = null): mixed
    {
        if ($name == null) {
            return $_POST;
        }
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    /**
     * Возвращает значение $_REQUEST параметра.
     * Если имя не указано, возвращает массив всех параметров POST.
     * 
     * @param string|null $name Имя $_REQUEST параметра.
     * @param mixed $default Значение по умолчанию, возвращаемое если параметр не существует.
     * 
     * @return mixed
     */
    public function param(?string $name, mixed $default = null): mixed
    {
        if ($name == null) {
            return $_REQUEST;
        }
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    }

    /**
     * Возвращает, является ли текущий запрос AJAX (XMLHttpRequest).
     * 
     * @return bool Возвращает true, если запрос является запросом AJAX (XMLHttpRequest).
     */
    protected function _isAjax(): bool
    {
        if (!isset($this->isAjax)) {
            $this->isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        }
        return $this->isAjax;
    }

    /**
     * Возвращает, является ли текущий запрос AJAX (XMLHttpRequest).
     * 
     * @return bool Возвращает `true`, если запрос является запросом AJAX (XMLHttpRequest).
     */
    public function isAjax(string $headerName = null): bool
    {
        if ($headerName) {
            return $this->_isAjax() && $this->getHeaders()->has($headerName);
        }
        return $this->_isAjax();
    }

    /**
     * Возвращает, является ли текущий запрос PJAX.
     * 
     * @return bool Возвращает `true`, если запрос является запросом PJAX.
     */
    public function IsPjax(): bool
    {
        if (!isset($this->IsPjax)) {
            $this->IsPjax = $this->isAjax('X-Pjax');
        }
        return $this->IsPjax;
    }

    /**
     * Возвращает, является ли текущий запрос GJAX.
     * 
     * @return bool Возвращает `true`, если запрос является запросом GJAX.
     */
    public function IsGjax(): bool
    {
        if (!isset($this->IsGjax)) {
            $this->IsGjax = $this->isAjax('X-Gjax') || isset($_POST['X-Gjax']);
        }
        return $this->IsGjax;
    }

    /**
     * Возвращает, является ли это запросом Adobe Flash или Flex.
     * 
     * @return bool Возвращает `true`, если запрос Adobe Flash или Adobe Flex.
     */
    public function IsFlash(): bool
    {
        if (!isset($this->IsFlash)) {
            $userAgent = $this->getHeaders()->get('User-Agent', '');
            $this->IsFlash = stripos($userAgent, 'Shockwave') !== false || stripos($userAgent, 'Flash') !== false;
        }
        return $this->IsFlash;
    }

    /**
     * Возвращает значение, показывающее, выполняется ли текущий запрос через командную строку.
     * 
     * @return bool Значение, указывающее, выполняется ли текущий запрос через консоль.
     */
    public function isConsole(): bool
    {
        return IS_CONSOLE;
    }

  /**
     * Возвращает абсолютный путь к исполняемому скрипту.
     * 
     * Простая реализация вернёт "$_SERVER['SCRIPT_FILENAME']".
     * 
     * @return string Абсолютный путь к исполняемому скрипту.
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function getScriptFile(): string
    {
        if (!isset($this->scriptFile)) {
            if (!isset($_SERVER['SCRIPT_FILENAME'])) {
                throw new Exception\InvalidArgumentException(Gm::t('app', 'Unable to determine the entry script file path'));
            }
            $this->scriptFile = $_SERVER['SCRIPT_FILENAME'];
        }
        return $this->scriptFile;
    }

    /**
     * Устанавливает абсолютный путь к исполняемому скрипту.
     * 
     * @param string $filename Абсолютный путь к исполняемому скрипту.
     * 
     * @return void
     */
    public function setScriptFile(string $filename): void
    {
        $this->scriptFile = $filename;
    }

    /**
     * Возвращает путь к текущему исполняемому скрипту.
     * 
     * Простая реализация вернёт "$_SERVER['SCRIPT_NAME']".
     * 
     * @return string
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function getScriptName(): string
    {
        if (!isset($this->scriptName)) {
            if (!isset($_SERVER['SCRIPT_NAME'])) {
                throw new Exception\InvalidArgumentException(Gm::t('app', 'Unable to determine the entry script file path'));
            }
            $this->scriptName = basename($_SERVER['SCRIPT_NAME']);
        }
        return $this->scriptName;
    }

    /**
     * Возвращает относительный URL-адрес исполняемого скрипта.
     *
     * @return string
     * 
     * @throws Exception\InvalidArgumentException
     */
    public function getScriptUrl(): string
    {
        if (!isset($this->scriptUrl)) {
            $scriptFile = $this->getScriptFile();
            $scriptName = basename($scriptFile);

            if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
                $this->scriptUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $scriptName) {
                $this->scriptUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
                $this->scriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && ($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
                $this->scriptUrl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
            } elseif (!empty($_SERVER['BASE_PATH']) && strpos($scriptFile, $_SERVER['BASE_PATH']) === 0) {
                $this->scriptUrl = str_replace(array($_SERVER['BASE_PATH'], '\\'), array('', '/'), $scriptFile);
            } else {
                throw new Exception\InvalidArgumentException(
                    Gm::t('app', 'Unable to determine the entry script URL')
                );
            }
        }
        return $this->scriptUrl;
    }

    /**
     * Возвращает относительный URL-адрес и путь исполняемого скрипта.
     *
     * @return array
     */
    public function getScript(): array
    {
        if (!isset($this->script)) {
            $scriptUrl  = $this->getScriptUrl();
            $scriptFile = basename($this->getScriptFile());
            $this->script = [
                'filename' => $scriptFile,
                'url'      => $scriptUrl,
                'path'     => rtrim($scriptUrl, $scriptFile)
            ];
        }
        return $this->script;
    }

    /**
     * Возвращает заголовки сообщений.
     *
     * @return Headers
     */
    public function getHeaders(): Headers
    {
        if (!isset($this->headers)) {
            $this->headers = new Headers();
            $this->headers->define();
        }
        return $this->headers;
    }

    /**
     * Возвращает значение параметра заголовка.
     * 
     * @param string $name Имя параметра.
     * @param mixed $default Значение по умолчнаию.
     * @param bool $сouple Если true, возвращает строку вида "параметр: значение", иначе значение параметра.
     * 
     * @return string|null
     */
    public function header(string $name, mixed $default = null, bool $сouple = false): ?string
    {
        return $this->getHeaders()->get($name, $default, $сouple);
    }

    /**
     * Возвращает IP на другом конце соединения.
     *
     * @return string
     */
    public function getRemoteIp(): ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    /**
     * Возвращает IP-адрес, с которого пользователь просматривает текущую страницу.
     *
     * @return string
     */
    public function getUserIp(): ?string
    {
        return $this->getRemoteIp();
    }

    /**
     * Возвращает удаленный хост, с которого пользователь просматривает текущую страницу.
     *
     * @return string
     */
    public function getRemoteHost(): ?string
    {
        return $_SERVER['REMOTE_HOST'] ?? null;
    }

    /**
     * Возвращает удаленный хост на другом конце соединения.
     *
     * @return string
     */
    public function getUserHost(): ?string
    {
        return $this->getRemoteHost();
    }

    /**
     * Возвращает User Agent.
     * 
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->getHeaders()->get('User-Agent');
    }

    /**
     * Возвращает номер порта сервера.
     * 
     * @return int|null Если null, номер порта сервера недоступен.
     */
    public function getServerPort(): ?string
    {
        return $_SERVER['SERVER_PORT'] ?? null;
    }

    /**
     * Возвращает имя сервера.
     * 
     * @return string|null Если null, имя сервера недоступно.
     */
    public function getServerName(): ?string
    {
        return $_SERVER['SERVER_NAME'] ?? null;
    }

    /**
     * Возвращает роль FCGI.
     * 
     * @return string|null Возвращает значение `null` если роль FCGI недоступна.
     */
    public function geServerFCGIRole(): ?string
    {
        return $_SERVER['FCGI_ROLE'] ?? null;
    }

    /**
     * Проверяет, использует ли сервер Fast CGI.
     * 
     * @return bool
     */
    public function serverUseFCGI(): bool
    {
        return isset( $_SERVER['FCGI_ROLE']);
    }

    /**
     * Возвращает URL источник запроса.
     * 
     * @return string|null Если null, URL источник запроса недоступен.
     */
    public function getReferrer(): ?string
    {
        return $this->getHeaders()->get('Referer');
    }

    /**
     * Возвращает URL адрес загрузки (из заголовка запроса "Origin"), если запрос отправлен как CORS.
     *
     * Информация о заголовке запроса "Origin" здесь {@link https://developer.mozilla.org/ru/docs/Web/HTTP/Заголовки/Origin}.
     *
     * @return string|null Если null, заголовок "Origin" в запросе отсутствует.
     */
    public function getOrigin(): ?string
    {
        return $this->getHeaders()->get('origin');
    }

    /**
     * Возвращает значение свойства hash интерфейса URL (идентификатор фрагмента 
     * URL после символа «#»).
     * 
     * @return string
     */
    public function getHash(): string
    {
        if ($this->hash === null) {
            $this->hash = $this->getQuery($this->hashParam, '');
        }
        return $this->hash;
    }

    /**
     * Возвращает токен, используемый для проверки CSRF.
     *
     * Этот токен создаётся для предотвращения breach атак {@link http://breachattack.com/}. 
     * Его можно передать через скрытое поле HTML-формы или значение заголовка HTTP для 
     * проверки CSRF.
     * 
     * Если токен ранее создан и получен запросом, то его возвратит {@see Request::readCsrfToken()}.
     * 
     * @param bool $regenerate Нужно ли регенерировать токен CSRF. Если true, то 
     *    каждый раз, когда вызывается этот метод, будет создаваться и сохраняться 
     *    новый токен CSRF (в сессии или в cookie).
     * 
     * @return string Токен, используемый для проверки CSRF.
     */
    public function getCsrfToken(bool $regenerate = null): string
    {
        if ($regenerate === null) {
            $regenerate = $this->regenerateCsrfToken;
        }
        if (!isset($this->csrfToken) || $regenerate) {
            // cookie, сессия или null
            $token = $this->readCsrfToken();
            if ($regenerate || empty($token)) {
                $token = $this->generateCsrfToken();
            }
            $this->csrfToken = $token;
        }
        return $this->csrfToken;
    }

    /**
     * Загружает токен CSRF из cookie или сессии.
     * 
     * @return null|string Токен CSRF, загруженный из cookie или сессии. Если cookie 
     *     или сессия не имеют токен CSRF, возвращает null.
     */
    public function readCsrfToken(): ?string
    {
        // если использовать токен для cookie
        if ($this->enableCsrfCookie) {
            $token = $this->getCsrfTokenFromCookie();
            if ($token !== null) {
                try {
                    $token = Gm::$app->encrypter->decryptString($token);
                } catch(\Exception $e) {
                    $token = null;
                }
                return $token;
            }
        }
        // если использовать токен для сессии
        if ($this->enableCsrfSession) {
            return Gm::$app->session->getToken();
        }
        return null;
    }

    /**
     * Создаёт незашифрованный случайный токен, используемый для проверки CSRF.
     * 
     * @return string Случайный токен для проверки CSRF.
     */
    protected function generateCsrfToken(): string
    {
       return Str::random(40);
    }

    /**
     * Вовзарщает токен CSRF, отправленный браузером через заголовок.
     * 
     * @return null|string Если заголовок {@see Request::$csrfHeaderName} не отправлен, 
     *     возвращает null.
     */
    public function getCsrfTokenFromHeader(): ?string
    {
        return $this->getHeaders()->get($this->csrfHeaderName);
    }

    /**
     * Вовзарщает токен CSRF, отправленный браузером через cookie.
     * 
     * @return null|string Если cookie {@see Request::$csrfCookieName} не отправлен, 
     *     возвращает null.
     */
    public function getCsrfTokenFromCookie(): ?string
    {
        return $_COOKIE[$this->csrfCookieName] ?? null;
    }

    /**
     * Проверка CSRF.
     *
     * Проверяет CSRF токен пользователя, сравнивая его с токеном хранящимся в cookie 
     * или в сессии.
     * 
     * В зависимости от проверки, можно выделить следующие методы защиты:
     *     - "Synchronizer Token Pattern" (Statefull). CSRF токен пользователя из полей 
     *     формы или заголовка (header) запроса cравнивается с токеном хранящимся в сессии.
     *     Для этого:
     *     ```php
     *     $request->enableCsrfValidation = true;
     *     $request->enableCsrfCookie     = false;
     *     $request->enableCsrfSession    = true;
     *     ```
     *     - "Double Submit Cookie" (Stateless). CSRF токен пользователя из полей формы или 
     *     заголовка (header) запроса cравнивается с токеном хранящимся в cookie.
     *     Для этого:
     *     ```
     *     $request->enableCsrfValidation = true;
     *     $request->enableCsrfCookie     = true;
     *     $request->enableCsrfSession    = false;
     *     ```
     *
     * Обратите внимание, что метод НЕ будет выполнять проверку CSRF, если 
     * {@see Request::$enableCsrfValidation} false или HTTP метод является безопасным 
     * {@see Request::$safeMethods}.
     *
     * @param string $clientToken CSRF токен пользователя для проверки. Если null, токен будет извлечен 
     *     из поле {@see Request::$csrfParam} POST или HTTP-заголовока.
     * @return bool Действителен ли токен CSRF. Если {@see Request::$enableCsrfValidation} false, 
     *     то метод вернёт true.
     */
    public function validateCsrfToken(string $clientToken = null): bool
    {
        // проверять только токен CSRF для небезопасных методов
        if (!$this->enableCsrfValidation || $this->isSafeMethod()) {
            return true;
        }
        $correctToken = $this->readCsrfToken();
        // если токен отсутсвует в сессии или в cookie
        if ($correctToken === null) {
            return false;
        }
        // если указан конкретный токен пользователя для проверки
        if ($clientToken !== null) {
            $token = $clientToken;
        } else {
            $token = $this->post($this->csrfParamName) ?: $this->getCsrfTokenFromHeader();
        }
        return is_string($token) && is_string($correctToken) && hash_equals($token, $correctToken);
    }

    /**
     * Создает cookie со случайно сгенерированным токеном CSRF.
     * 
     * Параметры конфигурации указанные в {@see Request::$csrfCookie}, будут 
     * применены к сгенерированному cookie.
     * Время жизни cookie в {@see Request::$csrfCookieLifeTime} в минутах. Если 0, 
     * является сессионным.
     * 
     * @see Request::$enableCsrfValidation
     * 
     * @param string $token Токен CSRF.
     * 
     * @return array|Cookie Если `$object = true`, cгенерированный cookie, иначе 
     *     параметры cookie.
     */
    public function createCsrfCookie(string $token, bool $object = false): array|Cookie
    {
        try {
            $token = Gm::$app->encrypter->encryptString($token);
        } catch (\Exception $e) {
            return null;
        }
        $cookie = array_merge(
            $this->csrfCookie, [
                'name'  => $this->csrfCookieName,
                'value' => $token
            ]
        );
        if ($this->csrfCookieLifeTime) {
            $cookie['expire'] = time() + 60 * $this->csrfCookieLifeTime;
        }
        if ($object)
            return $this->getCookies()->create($cookie);
        else
            return $cookie;
    }

    /**
     * @see Request::validateMarkupToken ()
     * 
     * @var null|false
     */
    protected ?bool $markupValidation = null;

    /**
     * Проверка разметки компонентов приложения.
     * 
     * Применяется для определения изменения параметров компонентов в визуальном 
     * редакторе с помощью разметки.
     * 
     * @return bool
     */
    public function validateBuildToken(): bool
    {
        if ($this->markupValidation === null) {
            if ($this->markupValidationKey) {
                /** @var null|string $key */
                $key = $this->cookie($this->markupCookieName);
                $this->markupValidation = $this->markupValidationKey === $key;
            } else
                $this->markupValidation = false;
        }
        return $this->markupValidation;
    }

    /**
     * Возвращает значение cookie или коллекцию `CookieCollection`.
     * 
     * @param null|string $name Имя cookie. Если null, возвратит коллекцию `CookieCollection`.
     * 
     * @return mixed Если `$name = null`, результат коллекция `CookieCollection`, иначе 
     *     значение или объект cookie.
     */
    public function cookie(string $name = null, bool $object = false): mixed
    {
        if ($name === null) {
            return $this->getCookies();
        } else {
            $cookie = $this->getCookies()->get($name);
            return $object ? $cookie : ($cookie ? $cookie->getValue() : null);
        }
    }

    /**
     * Возвращает коллекцию `CookieCollection`.
     * 
     * @see Request::loadCookies()
     * 
     * @return CookieCollection
     */
    public function getCookies(): CookieCollection
    {
        if (!isset($this->cookies)) {
            $this->cookies = $this->loadCookies();
        }
        return $this->cookies;
    }

    /**
     * Преобразует `$ _COOKIE` в коллекцию `CookieCollection`.
     * 
     * @return array Cookie полученные из запроса.
     * 
     * @throws Exception\InvalidConfigException Если {@see Request::$cookieValidationKey} 
     *     не установлен, когда  {@see Request::$enableCookieValidation} true.
     * @throws Exception\InvalidConfigException Если {@see Request::$cookieValidation} 
     *     не установлен, когда  {@see Request::$enableCookieValidation} true.
     */
    protected function loadCookies(): CookieCollection
    {
        $cookies = new CookieCollection($_COOKIE);
        // если необходимо проверять cookie
        if ($this->enableCookieValidation) {
            // если есть ключ проверки cookie
            if (empty($this->cookieValidationKey)) {
                throw new Exception\InvalidConfigException(
                    sprintf('%s::$cookieValidationKey must be configured with a secret key.', get_class($this))
                );
            }
            // если указаны какие cookie проверять
            if (empty($this->cookieValidation)) {
                throw new Exception\InvalidConfigException(
                    sprintf('%s::$cookieValidation must be configured with a cookie keys.', get_class($this))
                );
            }
            $cookies->decrypt($this->cookieValidation, $this->cookieValidationKey);
        }
        return $cookies;
    }
}
