<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use function redirect;
use function view;
use Eutranet\MySpace\Models\MySpaceUser;
use App\Models\User;

/**
 * The User agreement controller allow the authed user to display
 * a list of user agreements and to open user agreement details.
 */
class UserAgreementController extends Controller
{

	/**
	 * Access granted to authed user.
	 */
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
		// $this->authorizeResource(App\Models\Users\UserHasAgreement::class);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param User $user
	 * @return View|Factory|Application|RedirectResponse
	 */
	public function index(User $user): View|Factory|Application|RedirectResponse
	{
		if (Auth::id() === $user->id) {
			$userAgreements = MySpaceUser::where('id', $user->id)->first()->mySpaceGeneralTerms();
			return view('my-space::user-agreements.index', [
				'userAgreements' => $userAgreements ?? NULL,
				'user' => $user
			]);
		}
		Flash::error('You may not view someone else\'s agreement');
		return redirect()->route('my-space.dashboard');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param MySpaceUser|null $user
	 * @return Application|Factory|View|RedirectResponse
	 */
	public function show(?MySpaceUser $user): Application|Factory|View|RedirectResponse
	{
		if (Auth::id() === $user->id) {
			return view('my-space::user-agreements.show', [
				'user' => $user,
				'userAgreement' => $user->agreements
			]);
		}
		Flash::error('You may not view someone else\'s agreement');
		return redirect()->route('my-space.dashboard');
	}

}
