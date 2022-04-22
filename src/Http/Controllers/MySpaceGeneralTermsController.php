<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function redirect;
use function view;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;

/**
 * Notification controller allows user to access to the notificatinss
 */
class MySpaceGeneralTermsController extends Controller
{
	/**
	 * Access is granted to authenticated, verified users
	 */
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	/**
	 * Display the specified account.
	 * @return Application|Factory|View
	 */
	public function index(): View|Factory|Application
	{
		return view('my-space::my-space-general-terms.index');
	}

	/**
	 * Display the specified account.
	 * @param MySpaceGeneralTerm $mySpaceGeneralTerm
	 * @return Application|Factory|View
	 */
	public function show(MySpaceGeneralTerm $mySpaceGeneralTerm): View|Factory|Application
	{
		return view('my-space::my-space-general-terms.show', ['mySpaceGeneralTerm' => $mySpaceGeneralTerm]);
	}

}
