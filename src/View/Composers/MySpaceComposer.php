<?php

namespace Eutranet\MySpace\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Eutranet\MySpace\Models\MySpaceUser;
use Eutranet\MySpace\Repository\Eloquent\AccountRepository;

class MySpaceComposer
{
    protected AccountRepository $accountRepo;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepo = $accountRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $userId = Auth::id();
        if (Auth::check() && MySpaceUser::find($userId)->unreadNotifications()) {
            $userNotifications = MySpaceUser::find($userId)->unreadNotifications()->get();
        }

        $view
            ->with('userHasAcceptedGeneralTerms', $this->accountRepo->userHasAcceptedGeneralTerms($userId))
            ->with('userHasAcceptedMySpaceGeneralTerms', $this->accountRepo->userHasAcceptedMySpaceGeneralTerms($userId))
            ->with('unreadNotifications', $userNotifications)
            ->with('userStatus', $this->accountRepo->getAccountUserStatus($userId));
    }
}
