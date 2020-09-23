<?php

namespace Papaedu\Extension\Support;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Logger
{
    /**
     * @var string
     */
    protected $module = '';

    /**
     * Logger constructor.
     *
     * @param string $module
     */
    public function __construct($module = '')
    {
        if ($module) {
            $this->module = $module;
        }
    }

    /**
     * @param string $action
     * @param array  $fields
     * @param string $module
     */
    public function info(string $action, array $fields = [], string $module = '')
    {
        $module = $module ?: $this->module;

        Log::info("<{$module}> {$action} SUCCESS. {$this->getRequestUrl()}", array_filter([
            'fields' => $fields,
        ]));
    }

    /**
     * @param array  $context
     * @param string $action
     */
    public function start(array $context = [], $action = '')
    {
        $action = $action ?: 'start';
        Log::info("<{$this->module}> -----{$action}----- {$this->getRequestUrl()}", $context);
    }

    /**
     * @param array  $context
     * @param string $action
     */
    public function finish(array $context = [], $action = '')
    {
        $action = $action ?: 'finish';
        Log::info("<{$this->module}> -----{$action}----- {$this->getRequestUrl()}", $context);
    }

    /**
     * @param string $name
     * @param array  $context
     */
    public function createJob(string $name, array $context = [])
    {
        Log::info("<{$this->module}> -----Create Job ({$name})----- {$this->getRequestUrl()}", $context);
    }

    /**
     * @param string          $action
     * @param \Exception|null $exception
     * @param array           $fields
     * @param string          $module
     */
    public function error(string $action, ?Exception $exception, array $fields = [], string $module = '')
    {
        $module = $module ?: $this->module;
        if (is_null($exception)) {
            $exceptionMessage = '';
            $context = [
                'fields' => $fields,
            ];
        } else {
            $exceptionMessage = " (Exception code:{$exception->getCode()}, message:{$exception->getMessage()})";
            $context = [
                'fields' => $fields,
                'exception' => "\n[stacktrace]\n" . $exception->getTraceAsString(),
            ];
        }

        Log::error("<{$module}> {$action} FAILED. {$this->getRequestUrl()}{$exceptionMessage}", array_filter($context));
    }

    /**
     * @return string
     */
    private function getRequestUrl()
    {
        return '(Request ' . (App::runningInConsole() ? '<console>' : request()->url()) . ')';
    }
}
