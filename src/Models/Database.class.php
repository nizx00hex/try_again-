<?php

class Database
{
    private static ?PDO $connection = null;
    private static ?array $config = null;

    public static function connect(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $host = self::credentials('host');
        $port = self::credentials('port');
        $dbname = self::credentials('dbname');
        $charset = self::credentials('charset');

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

        try {
            self::$connection = new PDO(
                $dsn,
                self::credentials('username'),
                self::credentials('password'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            return self::$connection;

        } catch (PDOException $e) {
            throw new RuntimeException(
                'Database connection failed.',
                0,
                $e
            );
        }
    }

    public static function credentials(string $input): mixed
    {
        if (self::$config === null) {
            $location = dirname(__DIR__, 2) . '/database.json';

            if (!is_file($location)) {
                throw new RuntimeException(
                    "Configuration file not found: {$location}"
                );
            }

            $json = file_get_contents($location);

            if ($json === false) {
                throw new RuntimeException(
                    'Unable to read database configuration.'
                );
            }

            $config = json_decode($json, true);
            $location = basename($location);

            if (!is_array($config)) {
                throw new RuntimeException(
                    "Invalid {$location}: " . json_last_error_msg()
                );
            }

            self::$config = $config;
        }

        if (!array_key_exists($input, self::$config)) {
            throw new InvalidArgumentException(
                "Unknown database configuration key: {$input}"
            );
        }

        return self::$config[$input];
    }
}
