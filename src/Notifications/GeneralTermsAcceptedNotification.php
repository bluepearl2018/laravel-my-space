<?php

namespace Eutranet\MySpace\Notifications;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Eutranet\Setup\Models\GeneralTerm;
use Eutranet\MySpace\Models\MySpaceUser;

class GeneralTermsAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private GeneralTerm $generalTerm;
    private MySpaceUser $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MySpaceUser $user, GeneralTerm $generalTerm)
    {
        $this->generalTerm = $generalTerm;
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $route = route('general-terms.show', $this->generalTerm);
        return (new MailMessage())
            ->greeting('Hello ' . Auth::user()->name)
            ->line('You have read and accepted ' . $this->generalTerm->title)
            ->action('Here they are...', $route)
            ->line('You now have access to my space functionalities !');
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
            'title' => __('You have accepted our general terms.'),
            'user_id' => $this->user->id,
            'general_term_id' => $this->generalTerm->id,
        ];
    }
}
