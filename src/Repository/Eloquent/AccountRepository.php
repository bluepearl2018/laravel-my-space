<?php

namespace Eutranet\MySpace\Repository\Eloquent;

use Eutranet\Setup\Repository\BaseRepository;
use JetBrains\PhpStorm\Pure;
use Eutranet\MySpace\Models\MySpaceUser;
use Carbon\Carbon;

/**
 *
 */
class AccountRepository extends BaseRepository
{
    /**
     * @param MySpaceUser $mySpaceUser
     */
    #[Pure] public function __construct(MySpaceUser $mySpaceUser)
    {
        parent::__construct($mySpaceUser);
    }

    /**
     * @param int $mySpaceUserId
     * @return bool
     */
    public function accountIsDeletable(int $mySpaceUserId): bool
    {
        // To be deletable, the account should not be locked
        // Furthermore, the user should neither be a customer or an archive
        if (
            $this->accountUserStatus($mySpaceUserId) < 3 &&
            $this->accountIsLocked($mySpaceUserId) === false ||
            $this->accountUserStatus($mySpaceUserId) > 4 &&
            $this->accountIsLocked($mySpaceUserId) === false
        ) {
            return true;
        }
        return false;
    }

    /**
     * ------------------------------------------------------------------
     * ACCOUNT LOCK STATUS
     * ------------------------------------------------------------------
     * @param int $mySpaceUserId
     * @return void
     */
    public function lockAccount(int $mySpaceUserId): void
    {
        $this->model->find($mySpaceUserId)->update(['is_locked', true]);
    }

    /**
     * @param int $mySpaceUserId
     * @return void
     */
    public function unlockAccount(int $mySpaceUserId): void
    {
        $this->model->find($mySpaceUserId)->update(['is_locked', false]);
    }

    /**
     * @param int $mySpaceUserId
     * @return bool
     */
    public function accountIsLocked(int $mySpaceUserId): bool
    {
        return $this->model->find($mySpaceUserId)->is_locked;
    }


    /**
     * ------------------------------------------------------------------
     * ACCOUNT USER STATUS
     * ------------------------------------------------------------------
     * @param int $mySpaceUserId
     * @return void
     */
    public function accountUserStatus(int $mySpaceUserId)
    {
        return $this->model->find($mySpaceUserId)->user_status_id;
    }

    /**
     * @param int $mySpaceUserId
     * @return null
     */
    public function accountShouldBeDeletedOn(int $mySpaceUserId)
    {
        $accountDeletionRequestReceivedOn = $this->model->find($mySpaceUserId)->account_deletion_request_received_on;
        return $accountDeletionRequestReceivedOn?->addDays('90');
    }

    /**
     * @param int $mySpaceUserId
     * @return mixed
     */
    public function getAccountUserStatus(int $mySpaceUserId)
    {
        return $this->model->find($mySpaceUserId)->userStatus->name;
    }

    /**
     * @param int $mySpaceUserId
     * @return mixed
     */
    public function resetAccountDeletionRequest(int $mySpaceUserId)
    {
        return $this->model->find($mySpaceUserId)->update(['account_deletion_request_received_on' => null]);
    }


    /**
     * ------------------------------------------------------------------
     * GENERAL TERMS
     * ------------------------------------------------------------------
     * @param int $mySpaceUserId
     * @return bool
     */
    public function userHasAcceptedMySpaceGeneralTerms(int $mySpaceUserId): bool
    {
        return $this->model->find($mySpaceUserId)->has_accepted_my_space_general_terms_on !== null;
    }

    /**
     * @param int $mySpaceUserId
     * @return bool
     */
    public function userHasAcceptedGeneralTerms(int $mySpaceUserId): bool
    {
        return $this->model->find($mySpaceUserId)->has_accepted_general_terms_on !== null;
    }
}
