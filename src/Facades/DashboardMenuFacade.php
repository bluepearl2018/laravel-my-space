<?php

namespace Eutranet\Theme\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'dashboard-menu';
    }
}
