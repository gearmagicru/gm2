<?php
/**
 * Этот файл является частью пакета GM Framework.
 * 
 * @link https://gearmagic.ru/framework/
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Url;

use Gm;
use Gm\Stdlib\Service;

/**
 * UrlRules класс создаёт URL-адреса на основе правил.
 * 
 * UrlRules - это служба приложения, доступ к которой можно получить через `Gm::$app->urlRules`.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Url
 * @since 2.0
 */
class UrlRules extends Service
{
    /**
     * {@inheritdoc}
     */
     protected bool $useUnifiedConfig = true;

    /**
     * Название текущего правила.
     *
     * @var string
     */
    public string $rule = '';

    /**
     * Название правил с параметрами.
     *
     * @var array<string, array>
     */
    public array $rules = [];

    /**
     * {@inheritdoc}
     */
    public function getObjectName(): string
    {
        return 'urlRules';
    }

    /**
     * Выполняет правило.
     * 
     * Разбирает (парсит) URL-адрес согласно текущему правилу {@see UrlRules::$rule}.
     * 
     * @return void
     * 
     * @throws Exception\NotDefinedException Правило не найдено.
     */
    public function run(): void
    {
        if (empty($this->rule)) {
            throw new Exception\NotDefinedException(Gm::t('app', 'Rule is empty'));
        }

        if (!isset($this->rules[$this->rule])) {
            throw new Exception\NotDefinedException(Gm::t('app', 'Rule not exists "{0}"', [$this->rule]));
        }

        $ruleOptions = $this->rules[$this->rule];
        $parser = 'parse' . $this->rule;
        if (!method_exists($this, $parser)) {
            throw new Exception\NotDefinedException(Gm::t('app', 'Could not defined rule name "{0}"', [$parser]));
        }
        $this->$parser($ruleOptions);
    }

    /**
     * Вносит изменения в компоненты URL-адреса согласно указанному правилу.
     * 
     * @param array<string, mixed> $components Компоненты URL-адреса.
     * @param null|string $ruleName Имя правила. Если значение `null`, то будет применятся 
     *     текущее правило (по умолчанию `null`).
     * 
     * @return void
     */
    public function prepareUrlComponents(array &$components, ?string $ruleName = null): void
    {
        if ($ruleName === null) {
            $ruleName = $this->rule;
        }
        $this->{'rule' . $ruleName}($components, $this->rules[$this->rule]);
    }

    /**
     * Возвращает правило по его имени.
     * 
     * @param string $name Имя правила.
     * 
     * @return array|null Если `null`, правило отсутствует.
     */
    public function getRule(string $name): ?array
    {
        return $this->rules[$name] ?? null;
    }

    /**
     * Проверяет, существует ли правило.
     * 
     * @param string $name Имя правила.
     * 
     * @return bool
     */
    public function hasRule(string $name): bool
    {
        return isset($this->rules[$name]);
    }

    /**
     * Проверяет, совпадает ли текущее правило с указанным.
     * 
     * @param string $name Имя правила.
     * 
     * @return bool
     */
    public function isRule(string $name): bool
    {
        return $this->rule === $name;
    }
}
