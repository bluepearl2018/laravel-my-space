<?php

namespace Eutranet\MySpace\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Eutranet\Setup\Models\Admin;
use Eutranet\Setup\Models\Staff;
use Eutranet\MySpace\Models\MySpaceUser;

class AccountDeletionRequestWasCancelledMail extends Mailable
{
	use Queueable, SerializesModels;

	public MySpaceUser $user;
	private Admin $dataOfficer;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Admin $dataOfficer, Staff $staff, MySpaceUser $user)
	{
		$this->dataOfficer = $dataOfficer;
		$this->staff = $staff;
		$this->user = $user;
		$this->subject = config('app.name') . ' ' . __('Account deletion request cancelled');
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
			->to($this->user->email, $this->user->name)
			->subject($this->subject)
			->view('my-space::mails.account-deletion-request-was-cancelled', [
				'user' => $this->user,
				'title' => __('Your account deletion request was cancelled.')
			]);
	}
}
