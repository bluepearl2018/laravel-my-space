<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Eutranet\Be\Models\User;
use Auth;
use Carbon\Carbon;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mail;
use Eutranet\MySpace\Notifications\AccountPhoneWasUpdatedNotification;
use Eutranet\Setup\Models\Admin;
use Eutranet\Be\Models\Staff;
use Eutranet\MySpace\Mail\AccountDeletionRequestWasCancelledMail;
use Eutranet\MySpace\Notifications\AccountDeletionRequestWasCancelledNotification;
use Eutranet\MySpace\Models\MySpaceUser;
use Eutranet\MySpace\Mail\AccountDeletionRequestMail;
use Eutranet\MySpace\Notifications\AccountDeletionWasRequestedNotification;
use Eutranet\MySpace\Mail\AccountDeletionRequestFromCustomerMail;
use Eutranet\MySpace\Repository\Eloquent\AccountRepository;

/**
 * The Account controller is used in the user, front dashboard
 * It allows some operations on the user account by the authenticated user himself.
 */
class AccountController extends Controller
{

	protected AccountRepository $accountRepo;

	/**
	 * Account controller functions are for Authenticated users.
	 */
	public function __construct(AccountRepository $accountRepository)
	{
		$this->middleware('auth');
		$this->accountRepo = $accountRepository;
	}

	/**
	 * Display the specified account.
	 *
	 * @param User $user
	 * @return Application|Factory|View
	 */
	public function show(User $user): View|Factory|Application
	{
		// Make sure someone does not try to access someone else's info
		if ($user->id === Auth::id()) {
			return view('my-space::account.show', [
				'user' => MySpaceUser::findOrFail(Auth::id())
			]);
		}
		Flash::error('You may not view someone else\'s account');
		return abort('403');
	}

	/**
	 * Update the user account phone.
	 *
	 * @param Request $request
	 * @param User $user
	 * @return Application|Factory|View|RedirectResponse
	 */
	public function update(Request $request, User $user): View|Factory|RedirectResponse|Application
	{
		// Make sure someone does not try to update someone else's info
		if ($user->id === Auth::id()) {
			$rules = [
				'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:16'
			];
			$validated = $request->validate($rules);
			$user = MySpaceUser::find($user->id);
			$user->update($validated);
			$user->notify(new AccountPhoneWasUpdatedNotification($user));
			return view('my-space::account.show', ['user' => $user]);
		}
		Flash::error('You may not update someone else\'s phone');
		return redirect()->route('my-space.dashboard');
	}

	/**
	 * Cancel account deletion request.
	 *
	 * @param Request $request
	 * @param \App\Models\User $user
	 * @return RedirectResponse
	 */
	public function cancelDestroy(Request $request, \App\Models\User $user): RedirectResponse
	{
		// Authorize if logged in owner is the $user
		if ($user->id === Auth::id()) {
			// Avoid abuses...
			$troublemakingScore = $user->troublemaking_score;
			if ($troublemakingScore < 5) {
				// Increase the trouble making score by 1
				$troublemakingScore = $user->troublemaking_score += 1;
				$user->update(['troublemaking_score' => $troublemakingScore]);
				// Retrieve the dataOfficer
				$staff = Staff::findOrFail(1);
				// Retrieve the dataOfficer
				$dataOfficer = Admin::findOrFail(2);
				// No back-office staff should be able to modify data
				$this->accountRepo->unlockAccount(Auth::id());
				$this->accountRepo->resetAccountDeletionRequest(Auth::id());

				// Send a mailable to GDPR Corporate admin administrator
				Flash::success(trans('Account deletion request cancelled.'));
				Mail::send(new AccountDeletionRequestWasCancelledMail($dataOfficer, $staff, MySpaceUser::find(Auth::id())));
				// And notify the user
				$user->notify(new AccountDeletionRequestWasCancelledNotification(MySpaceUser::find(Auth::id())));
				return redirect()->route('my-space.my-account', $user);
			} elseif ($troublemakingScore = 5) {
				// Too many deletion requests. Abnormal behaviour.
				$user->update(['is_locked' => true, 'account_deletion_request' => NULL]);
				Flash::warning(trans('The system has detected repeated abnormal transactions. Your account is now blocked.'));
				return redirect()->route('my-space.my-account', $user);
			}
		}
		Flash::error(trans('You may not update someone else\'s account'));
		return redirect()->route('my-space.dashboard');
	}

	/**
	 * Destroy account request
	 * NOT DELETION
	 *
	 * @param Request $request
	 * @param MySpaceUser $user
	 * @return RedirectResponse
	 */
	public function destroy(Request $request, MySpaceUser $user): RedirectResponse
	{
		// Authorize if logged in owner is the $user
		if ($user->id === Auth::id()) {
			// Avoid abuses...
			$troublemakingScore = $user->troublemaking_score;
			if ($troublemakingScore >= 5) {
				// Too many deletion requests. Abnormal behaviour.
				$user->update(['is_locked' => true]);
				Flash::warning(trans('The system has detected repeated abnormal transactions. Your account is now blocked.'));
				return redirect()->route('my-space.dashboard');
			} else {
				// Increase the trouble making score by 1
				$troublemakingScore = $user->troublemaking_score += 1;
				$user->update(['troublemaking_score' => $troublemakingScore]);
				// Get the main staff...
				$staff = Staff::findOrFail(1);
				// Retrieve the dataOfficer
				$dataOfficer = Admin::findOrFail(2);
				// Send a mailable to GDPR Corporate admin administrator
				Mail::send(new AccountDeletionRequestMail($dataOfficer, $staff, $user));
				$user->notify(new AccountDeletionWasRequestedNotification($user));
				// No back-office staff should be able to modify data
				// The system blocks the account and a deletion date + 90 days is added
				$user->update(['is_locked' => true, 'account_deletion_request_received_on' => Carbon::now()]);
				// If the user is not a customer
				if ($user->userStatus->id <> 3) {
					// Send a mailable to GDPR Corporate admin administrator
					Flash::success(trans('An account deletion request has been sent to our Data officer'));
					return redirect()->route('my-space.my-account', $user);
				} // But if the user is customer
				elseif ($user->userStatus->id = 3) {
					// Get the main staff...
					$staff = Staff::findOrFail(1);
					// Retrieve the dataOfficer
					$dataOfficer = Admin::findOrFail(2);
					// Send a mailable to GDPR Corporate admin administrator
					Mail::send(new AccountDeletionRequestFromCustomerMail($dataOfficer, $staff, $user));
					Flash::error(trans('Your account cannot be deleted, because your are a customer.'));
					return redirect()->route('my-space.my-account', $user);
				}
				Flash::error(trans('For some reason, your account cannot be deleted. Please contact the staff.'));
				return redirect()->route('my-space.my-account', $user);
			}
		}
		Flash::error(trans('You may not update someone else\'s account'));
		return redirect()->route('my-space.dashboard');
	}

}
