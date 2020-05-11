<?php

namespace Papaedu\Extension\Support;

use PDO;

class DbConnection
{
    public static function getMysqlConnections(array $names = [])
    {
        $connectionConfig = static::getConnectionConfig();

        $connections = [];
        foreach ($names as $name) {
            $nameArray = explode('_', $name);
            $key = strtoupper($nameArray[1] ?? '');
            $key = $key ? "_{$key}" : $key;
            $connectionConfig['database'] = env("DB_DATABASE{$key}", 'forge');
            $connections[$name] = $connectionConfig;
        }

        return $connections;
    }

    protected static function getConnectionConfig()
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
            'engine' => null,
            'modes' => [],
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ];
    }
}