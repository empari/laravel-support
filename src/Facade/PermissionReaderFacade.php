<?php namespace Empari\Laravel\Support\Facade;

use Illuminate\Support\Facades\Facade;
use Empari\Laravel\Support\Annotations\PermissionReader as PermissionReaderService;

class PermissionReaderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return PermissionReaderService::class;
    }
}