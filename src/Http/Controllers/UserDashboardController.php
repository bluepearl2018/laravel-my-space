<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function view;

/**
 * The User dashboard controller calls the dashboard
 * This is where authenticated users perform a lot of operations.
 */
class UserDashboardController extends Controller
{
	/**
	 * Access to user dashboard is granted to authenticated, verified users
	 */
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	/**
	 * Get access to the dashbooard
	 * @return Application|Factory|View
	 */
	public function index(): View|Factory|Application
	{
		return view('my-space::dashboard.index', ['user' => Auth::user()]);
	}
}
