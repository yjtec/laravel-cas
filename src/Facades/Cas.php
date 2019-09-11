<?php
namespace Yjtec\Cas\Facades;
use Illuminate\Support\Facades\Facade;
class Cas extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cas';
    }
}