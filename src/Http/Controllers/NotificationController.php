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

/**
 * Notification controller allows user to access to the notificatinss
 */
class NotificationController extends Controller
{
    /**
     * Access is granted to authenticated, verified users
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * @param User $user
     * @return View|Factory|Application|RedirectResponse
     */
    public function index(User $user): View|Factory|Application|RedirectResponse
    {
        // Make sure the logged in $user is the consultation "owner"
        if (Auth::id() === $user->id) {
            return view('my-space::user-notifications.index', ['user-notifications' => $user->notifications]);
        }
        Flash::error('You may not view someone else\'s user-notifications');
        return redirect()->route('my-space.dashboard');
    }

    /**
     * Display the specified account.
     * @param User $user
     * @param Notification $notification
     * @return Application|Factory|View
     */
    public function show(User $user, Notification $notification): View|Factory|Application
    {
        return view('my-space::user-notifications.show', ['notification' => $notification, 'user' => $user]);
    }
}
