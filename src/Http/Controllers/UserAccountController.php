<?php

namespace Eutranet\MySpace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * The User account controller used in my space is exclusively for the user himself.
 *
 */
class UserAccountController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('setup.users.index');
    }
    /**
     * Desactivate the user account.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function toggleIsActive(Request $request, User $user): RedirectResponse
    {
        if ($user->is_active === 1) {
            $user->update(['is_active' => false]);
            Flash::success('User account is now inactive');
            return redirect()->route('my-space::users.show', $user);
        }

        $user->update(['is_active' => true]);
        Flash::success('Your account is now active');
        return redirect()->route('my-space::users.show', $user);
    }
}
