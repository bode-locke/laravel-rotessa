<?php
namespace BodeLocke\Rotessa\Facades;
use Illuminate\Support\Facades\Facade;
class Rotessa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rotessa';
    }
}
