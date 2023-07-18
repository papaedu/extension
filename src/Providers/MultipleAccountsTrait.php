<?php

namespace Papaedu\Extension\Providers;

trait MultipleAccountsTrait
{
    protected function singletonMultipleAccountsApp(string $name, array $apps, callable $appendConfig = null): void
    {
        foreach ($apps as $appName => $appConfig) {
            $fullConfigName = "{$name}.{$appName}";
            $fullAppName = str_replace('-', '_', $fullConfigName);
            if (is_null(config("{$fullConfigName}"))) {
                continue;
            }
            if (is_null(config("{$fullConfigName}.{$appConfig['must_key']}"))) {
                $accounts = config($fullConfigName);
            } else {
                $accounts = [
                    'default' => config($fullConfigName),
                ];
                config(["{$fullConfigName}.default" => $accounts['default']]);
            }

            foreach ($accounts as $account => $config) {
                if (is_callable($appendConfig)) {
                    $appendConfig($config);
                }

                $this->app->singleton("{$fullAppName}.{$account}", fn ($app) => new $appConfig['name']($config));
            }
            $this->app->alias("{$fullAppName}.default", $fullAppName);
        }
    }
}
