<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Eutranet\Setup\Models\GeneralTerm;
use Eutranet\MySpace\Notifications\MySpaceGeneralTermAcceptedNotification;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;
use Carbon\Carbon;
use Eutranet\MySpace\Models\MySpaceUser;
use Illuminate\Foundation\Auth\User;
use Eutranet\MySpace\Notifications\GeneralTermsAcceptedNotification;

/**
 * The Account controller is used in the user, front dashboard
 * It allows some operations on the user account by the authenticated user himself.
 */
class UserGeneralTermController extends Controller
{

	/**
	 * Account controller functions are for Authenticated users.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Desactivate the user account.
	 *
	 * @param Request $request
	 * @param User $user
	 * @param GeneralTerm $generalTerm
	 * @return Application|Factory|RedirectResponse|View
	 */
	public function readAndAcceptTerms(Request $request, User $user, GeneralTerm $generalTerm): View|Factory|RedirectResponse|Application
	{
		if ($request->method() === 'POST') {
			if ($user->has_accepted_general_terms_on === false || $user->has_accepted_general_terms_on === null) {
				$user = MySpaceUser::findOrFail(Auth::id());
				$user->update(['has_accepted_general_terms_on' => Carbon::now()]);
				Flash::success(__('Thanks for your confirmation.'));
				$user->notify(new GeneralTermsAcceptedNotification($user, $generalTerm));
				return redirect()->route('my-space.dashboard');
			} else {
				Flash::warning('You have already read and accepted our general terms');
				return redirect()->route('my-space.dashboard');
			}
		} elseif ($request->method() === 'GET') {
			$classLead = MySpaceGeneralTerm::getClassLead();
			return view('my-space::general-terms.show', [
				'classLead' => $classLead,
				'generalTerm' => $generalTerm,
				'infix' => '-my-space'
			]);
		}
		Flash::error('Whoops!');
		return redirect()->route('my-space.dashboard');
	}

	/**
	 * Desactivate the user account.
	 *
	 * @param Request $request
	 * @param User $user
	 * @param MySpaceGeneralTerm $mySpaceGeneralTerm
	 * @return Application|Factory|RedirectResponse|View
	 */
	public function readAndAcceptMySpaceGeneralTerms(
		Request $request,
		User $user,
		MySpaceGeneralTerm $mySpaceGeneralTerm): View|Factory|RedirectResponse|Application
	{
		// Retrieve the alias ... Eutranet\Be\Models\User as AccountUser

		if ($request->method() === 'POST') {
			if ($user->has_accepted_my_space_general_terms_on === false || $user->has_accepted_my_space_general_terms_on === null) {
				$user = MySpaceUser::findOrFail(Auth::id());
				$user->update(['has_accepted_my_space_general_terms_on' => Carbon::now()]);
				if($user->is_locked === 1){
					$user->update(['is_locked' => false]);
				};
				Flash::success(__('Thanks for your confirmation.'));
				$user->notify(new MySpaceGeneralTermAcceptedNotification($user, $mySpaceGeneralTerm));
				return redirect()->route('my-space.dashboard');
			} else {
				Flash::warning('You have already read and accepted our general terms');
				return redirect()->route('my-space.dashboard');
			}
		} elseif ($request->method() === 'GET') {
			$classLead = MySpaceGeneralTerm::getClassLead();
			return view('my-space::my-space-general-terms.show', [
				'classLead' => $classLead,
				'mySpaceGeneralTerm' => $mySpaceGeneralTerm,
				'infix' => '-my-space'
			]);
		}
		Flash::error('Whoops!');
		return redirect()->route('my-space.dashboard');
	}
}
