<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddProductNotification extends Notification
{
    use Queueable;
    private $product_id;
    private $user_create_emp;
    private $product_name;
    private $type;
    // ++++++++++++++++++++++++++++ __construct() ++++++++++++++++++++++++++++
    public function __construct($product_id,$user_create_emp,$product_name,$type)
    {
        $this->product_id = $product_id;
        $this->user_create_emp = $user_create_emp;
        $this->product_name = $product_name ;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'type' => $this->type,
            'created_by' => $this->user_create_emp,
        ];
    }
}
