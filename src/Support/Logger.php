<?php

namespace Papaedu\Extension\Support;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

/**
 * @deprecated
 */
class Logger
{
    /**
     * @var string
     */
    protected string $module = '';

    /**
     * Logger constructor.
     *
     * @param  string  $module
     */
    public function __construct(string $module = '')
    {
        if ($module) {
            $this->module = $module;
        }
    }

    /**
     * @param  string  $action
     * @param  array  $context
     * @param  string  $module
     */
    public function info(string $action, array $context = [], string $module = '')
    {
        $module = $module ?: $this->module;

        Log::channel('runlog')->info("<{$module}> {$action} SUCCESS. {$this->getRequestUrl()}", $context);
    }

    /**
     * @param  array  $context
     * @param  string  $action
     */
    public function start(array $context = [], $action = '')
    {
        $action = $action ?: 'start';
        Log::channel('runlog')->info("<{$this->module}> -----{$action}----- {$this->getRequestUrl()}", $context);
    }

    /**
     * @param  array  $context
     * @param  string  $action
     */
    public function finish(array $context = [], $action = '')
    {
        $action = $action ?: 'finish';
        Log::channel('runlog')->info("<{$this->module}> -----{$action}----- {$this->getRequestUrl()}", $context);
    }

    /**
     * @param  string  $name
     * @param  array  $context
     */
    public function createJob(string $name, array $context = [])
    {
        Log::channel('runlog')->info(
            "<{$this->module}> -----Create Job ({$name})----- {$this->getRequestUrl()}",
            $context
        );
    }

    /**
     * @param  string  $action
     * @param  \Exception|null  $exception
     * @param  array  $fields
     * @param  string  $module
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
                'exception' => "\n[stacktrace]\n".$exception->getTraceAsString(),
            ];
        }

        Log::channel('runlog')->error(
            "<{$module}> {$action} FAILED. {$this->getRequestUrl()}{$exceptionMessage}",
            array_filter($context)
        );
    }

    /**
     * @return string
     */
    private function getRequestUrl(): string
    {
        return '(Request '.(App::runningInConsole() ? '<console>' : request()->url()).')';
    }
}
