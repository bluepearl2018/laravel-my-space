<?php

namespace Eutranet\MySpace\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Eutranet\Setup\Models\Admin;
use Eutranet\Setup\Models\StaffMember;
use Eutranet\MySpace\Models\MySpaceUser;

class AccountDeletedMail extends Mailable
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
    public function __construct(?Admin $dataOfficer, ?MySpaceUser $user)
    {
        $this->dataOfficer = $dataOfficer;
        $this->user = $user;
        $this->subject = config('app.name') . ' ' . __('Account deleted according GDPR');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->to($this->dataOfficer->email, $this->dataOfficer->name)
            ->subject($this->subject)
            ->view('my-space::mails.account-deleted', [
                'user' => $this->user,
                'title' => 'Account deleted',
                'dataOfficer' => $this->dataOfficer
            ]);
    }
}
