<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Exception;

use Gm;

/**
 * Исключение возникающие на этапе загрузки приложения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Exception
 * @since 2.0
 */
class BootstrapException extends ErrorException
{
    /**
     * @var string Файл шаблона сообщения исключения с форматированием.
     */
    public string $viewFile = '/views/errorHandler/bootstrapError.php';

    /**
     * @var string Файл шаблона сообщения исключения без форматирования.
     */
    public string $plainViewFile = '/views/errorHandler/plainBootstrapError.php';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Bootstrap Exception';
    }

    /**
     * Выводит файл шаблона с указанными параметрами.
     * 
     * @param string $filename Файл шаблона.
     * @param array $params Параметры (пары имя-значение), которые будут извлечены и доступны в файле шаблона.
     * 
     * @return string Результат рендеринга.
     */
    public function renderFile(string $filename, array $params): string
    {
        $params['exception'] = $this;
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require BASE_PATH . $filename;
        return ob_get_clean();
    }

    /**
     * Выводит файл шаблона.
     * 
     * @param bool $plain Если true, выводит текст сообщения без форматирования.
     * 
     * @return void
     */
    public function render(bool $plain = false): void
    {
        Gm::cleanOutputBuffer();

        echo $this->renderFile(
            $plain ? $this->plainViewFile : $this->viewFile,
            [
                'message' => GM_DEBUG ? $this->message : 'An internal server error occurred.'
            ]
        );
        exit;
    }
}
