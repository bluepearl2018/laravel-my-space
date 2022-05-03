<?php

namespace Eutranet\MySpace\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Eutranet\MySpace\Models\MySpaceUser;
use Eutranet\MySpace\Repository\Eloquent\AccountRepository;

class UserAccountComposer
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
        $accountIsDeletable = $this->accountRepo->accountIsDeletable($userId);
        $accountShouldBeDeletedOn = $this->accountRepo->accountShouldBeDeletedOn($userId);

        $view
            ->with('accountIsDeletable', $accountIsDeletable)
            ->with('accountShouldBeDeletedOn', $accountShouldBeDeletedOn)
        ;
    }
}
