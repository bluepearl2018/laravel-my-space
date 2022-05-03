<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

/**
 * My Space installation controller is the installation checker controller
 */
class MySpaceInstallationController extends Controller
{
    /**
     * Only admin can check installation status
     */
    public function __construct()
    {
        $this->middleware(['auth:admin']);
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('my-space::installer.index');
    }
}
