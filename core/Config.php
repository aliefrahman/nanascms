<?php

namespace Core;

class Config
{
    private static array $configs = [];
    private static bool $envLoaded = false;

    /**
     * Load environment variables dari file .env
     */
    public static function loadEnv(): void
    {
        if (self::$envLoaded) {
            return;
        }

        $path = dirname(__DIR__) . '/.env';
        if (file_exists($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // Abaikan baris komentar
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                $parts = explode('=', $line, 2);
                if (count($parts) === 2) {
                    $name = trim($parts[0]);
                    $value = trim(trim($parts[1]), '"\'');

                    if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                        putenv(sprintf('%s=%s', $name, $value));
                        $_ENV[$name] = $value;
                        $_SERVER[$name] = $value;
                    }
                }
            }
        }
        self::$envLoaded = true;
    }

    public static function env(string $key, $default = null)
    {
        self::loadEnv();
        $value = getenv($key);
        return $value !== false ? $value : ($_ENV[$key] ?? $default);
    }

    /**
     * Load konfigurasi dari file di dalam folder config/
     */
    public static function load(string $file): void
    {
        $path = dirname(__DIR__) . "/config/{$file}.php";
        if (file_exists($path)) {
            self::$configs[$file] = require $path;
        }
    }

    /**
     * Ambil nilai dari konfigurasi menggunakan dot notation (misal: 'app.base_url')
     */
    public static function get(string $key, $default = null)
    {
        $parts = explode('.', $key);
        $file = array_shift($parts);

        if (!isset(self::$configs[$file])) {
            self::load($file);
        }

        $value = self::$configs[$file] ?? [];

        foreach ($parts as $part) {
            if (is_array($value) && array_key_exists($part, $value)) {
                $value = $value[$part];
            } else {
                return $default;
            }
        }

        return $value;
    }
}