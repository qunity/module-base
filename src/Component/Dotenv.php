<?php

declare(strict_types=1);

namespace Qunity\Base\Component;

use Symfony\Component\Dotenv\Dotenv as SymfonyDotenv;

// @phpcs:disable Magento2
class Dotenv
{
    public const ENV_KEY = 'APP_ENV';
    public const DEBUG_KEY = 'APP_DEBUG';

    public const VARIABLE_NAME = 'variable_name';
    public const VARIABLE_VALUE = 'variable_value';

    /**
     * @var array
     */
    private static array $cache = [];

    /**
     * Create Symfony Dotenv component
     *
     * @param string $envKey
     * @param string $debugKey
     *
     * @return SymfonyDotenv
     */
    public static function create(string $envKey = self::ENV_KEY, string $debugKey = self::DEBUG_KEY): SymfonyDotenv
    {
        return new SymfonyDotenv($envKey, $debugKey);
    }

    /**
     * Get environment variable values
     *
     * @param array $values
     * @param array $callbacks
     *
     * @return array
     */
    public static function values(array $values, array $callbacks = []): array
    {
        foreach ($values as $name => &$value) {
            $value = self::value($name, $value, $callbacks);
        }

        return $values;
    }

    /**
     * Get environment variable value
     *
     * @param string $name
     * @param mixed $default
     * @param array $callbacks
     *
     * @return mixed
     */
    public static function value(string $name, mixed $default = null, array $callbacks = []): mixed
    {
        self::prepareName($name, $callbacks);
        if (isset(self::$cache[$name])) {
            return self::$cache[$name];
        }

        if (($value = getenv($name)) === false) {
            $value = $default;
        }

        self::prepareValue($value, $callbacks);
        self::$cache[$name] = $value;

        return $value;
    }

    /**
     * Prepare environment variable name
     *
     * @param string $name
     * @param array $callbacks
     *
     * @return void
     */
    private static function prepareName(string &$name, array $callbacks = []): void
    {
        if (isset($callbacks[self::VARIABLE_NAME])) {
            foreach ($callbacks[self::VARIABLE_NAME] as $callback) {
                $name = call_user_func($callback, $name);
            }
        }

        $name = strtoupper($name);
    }

    /**
     * Prepare environment variable value
     *
     * @param mixed $value
     * @param array $callbacks
     *
     * @return void
     */
    private static function prepareValue(mixed &$value, array $callbacks = []): void
    {
        if (isset($callbacks[self::VARIABLE_VALUE])) {
            foreach ($callbacks[self::VARIABLE_VALUE] as $callback) {
                $value = call_user_func($callback, $value);
            }
        }
    }
}
// @phpcs:enable Magento2
