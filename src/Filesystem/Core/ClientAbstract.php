<?php

namespace Papaedu\Extension\Filesystem\Core;

use InvalidArgumentException;

abstract class ClientAbstract
{
    protected array $disks = [];

    public function __call(string $disk, array $arguments)
    {
        if (! isset($this->disks[$disk])) {
            $calledClass = get_called_class();
            $class = str_replace('Client', ucfirst($disk).'Adapter', $calledClass);

            if (! class_exists($class)) {
                throw new InvalidArgumentException("Disk name '{$disk}' is invalid.");
            }
            $this->disks[$disk] = $this->newClass($class, $disk);
        }

        return $this->disks[$disk];
    }

    abstract protected function newClass(string $class, string $disk);
}
