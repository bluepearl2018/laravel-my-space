<?php

namespace Eutranet\MySpace\Notifications;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Eutranet\MySpace\Models\MySpaceGeneralTerm;
use Eutranet\MySpace\Models\MySpaceUser;

class MySpaceGeneralTermAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private MySpaceGeneralTerm $generalTerm;
    private MySpaceUser $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MySpaceUser $mySpaceUser, MySpaceGeneralTerm $mySpaceGeneralTerm)
    {
        $this->generalTerm = $mySpaceGeneralTerm;
        $this->user = $mySpaceUser;
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
        $route = route('corporate-general-terms.show', $this->generalTerm);
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
            'title' => __('You have accepted the "My Space" general terms.'),
            'user_id' => $this->user->id,
            'my_space_general_term_id' => $this->generalTerm->id,
        ];
    }
}
