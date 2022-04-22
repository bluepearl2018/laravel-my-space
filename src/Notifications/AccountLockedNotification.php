<?php

namespace Eutranet\MySpace\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Eutranet\MySpace\Models\MySpaceUser;

/**
 * The account locked notification is sent when the system detects too many
 * updates... on account deletion / restoration.
 */
class AccountLockedNotification extends Notification implements ShouldQueue
{
	use Queueable;

	/**
	 * @var MySpaceUser
	 */
	private MySpaceUser $user;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(MySpaceUser $user)
	{
		$this->user = $user;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable): array
	{
		return ['mail', 'database'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return MailMessage
	 */
	public function toMail($notifiable): MailMessage
	{
		// Instead of defining the "lines" of text in the notification class,
		// you may use the view method to specify a custom template that should be used to
		// render the notification email:
		return (new MailMessage)
			->view('my-space::mails.accounts.locked', [
				'notifiable' => $notifiable,
				'user' => $this->user
			]);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'title' => __('Your account was locked.'),
			'user_id' => $this->user->id,
		];
	}
}
