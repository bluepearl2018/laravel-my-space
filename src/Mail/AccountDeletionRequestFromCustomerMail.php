<?php

namespace Eutranet\MySpace\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Eutranet\Setup\Models\Admin;
use Eutranet\Setup\Models\StaffMember;
use Eutranet\MySpace\Models\MySpaceUser;

class AccountDeletionRequestFromCustomerMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public MySpaceUser $user;
    private Admin $dataOfficer;
    private StaffMember $staffMember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $dataOfficer, StaffMember $staffMember, MySpaceUser $user)
    {
        $this->dataOfficer = $dataOfficer;
        $this->staff = $staffMember;
        $this->user = $user;
        $this->subject = config('app.name') . ' ' . __('Account deletion request');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        // Todo change customer domain.tld
        // Todo check attachments from resources and storage
        // Todo replace dummy pdf
        return $this->from(env('MAIL_NO_REPLY'), env('APP_NAME') . ' - ' . $this->dataOfficer->name)
            ->to($this->dataOfficer->email, $this->dataOfficer->name)
            ->to($this->staff->email, $this->staff->name)
            ->to($this->user->email, $this->user->name)
            ->subject($this->subject)
            ->view('my-space::mails.account-deletion-request', [
                'user' => $this->user,
                'title' => __('Your a customer: we cannot delete your account.')
            ]);
    }
}
