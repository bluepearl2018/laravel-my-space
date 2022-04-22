<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use Eutranet\Be\Traits\BackendNotificationTrait;
use Eutranet\Be\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class UserNotificationController extends Controller
{
	use BackendNotificationTrait;

	public function index(User $user): Factory|View|Application
	{
		return view('my-space::user-notifications.index', ['userNotifications' => $user->unreadNotifications()->get()]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param DatabaseNotification $notification
	 * @return RedirectResponse
	 * @internal param int $id
	 */
	public function update(Request $request, DatabaseNotification $notification): RedirectResponse
	{
		$notification->markAsRead();
		if($request->user()->unreadNotifications->isEmpty()) {
			return redirect()->route('my-space::dashboard.index');
		}
		return back();
	}
}