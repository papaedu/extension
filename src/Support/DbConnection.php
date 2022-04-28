<?php

namespace Papaedu\Extension\Support;

use PDO;

class DbConnection
{
    /**
     * @param  array  $names
     * @return array
     */
    public static function getMysqlConnections(array $names = []): array
    {
        $connectionConfig = static::getConnectionConfig();

        $connections = [];
        foreach ($names as $name) {
            $nameArray = explode('_', $name, 2);
            $key = strtoupper($nameArray[1] ?? '');
            $key = $key ? "_{$key}" : $key;
            $connectionConfig['database'] = env("DB_DATABASE{$key}", 'forge');
            $connections[$name] = $connectionConfig;
        }

        return $connections;
    }

    /**
     * @return array
     */
    protected static function getConnectionConfig(): array
    {
        return [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'modes' => ['STRICT_TRANS_TABLES', 'NO_ZERO_IN_DATE', 'NO_ZERO_DATE', 'ERROR_FOR_DIVISION_BY_ZERO', 'NO_ENGINE_SUBSTITUTION'],
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ];
    }
}
