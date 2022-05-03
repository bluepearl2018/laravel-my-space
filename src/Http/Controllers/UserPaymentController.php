<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Eutranet\MySpace\Models\UserPayment;

/**
 * The user paument controller grants access to a list and detail views
 * for user payments
 */
class UserPaymentController extends Controller
{
    /**
     * Accss granted to verified and authenticated users
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
            $userPayments = UserPayment::where('user_id', $user->id)->get();
            return view('my-space::user-payments.index', ['userPayments' => $userPayments]);
        }
        Flash::error('You may not view someone else\'s payment');
        return redirect()->route('my-space.dashboard');
    }

    /**
     * Display the specified account.
     * @param User $user
     * @param UserPayment $userPayment
     * @return View|Factory|Application|RedirectResponse
     */
    public function show(User $user, UserPayment $userPayment): View|Factory|Application|RedirectResponse
    {
        // Make sure the logged in $user is the consultation "owner"
        if (Auth::id() === $userPayment->user_id) {
            return view('my-space::user-payments.show', ['userPayment' => $userPayment]);
        }
        Flash::error('You may not view someone else\'s payment');
        return redirect()->route('my-space.dashboard');
    }
}
