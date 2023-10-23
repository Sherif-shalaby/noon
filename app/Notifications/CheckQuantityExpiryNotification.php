<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckQuantityExpiryNotification extends Notification
{
    use Queueable;

    // +++++++++++++++++++ private variables +++++++++++++++++++
    private $user_id , $product_id , $qty_available ,
            $alert_quantity , $days , $status ,
            $created_by , $type;
    // ++++++++++++++++++ constructor +++++++++++++++++
    public function __construct($user_id , $product_id , $qty_available ,
                                $alert_quantity , $status ,
                                $created_by , $type)
    {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->qty_available = $qty_available ;
        $this->alert_quantity = $alert_quantity ;
        $this->status = $status ;
        $this->created_by = $created_by ;
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
            'user_id' => $this->user_id ,
            'product_id' => $this->product_id ,
            'product_id' => $this->product_id ,
            'qty_available' => $this->qty_available ,
            'alert_quantity' => $this->alert_quantity ,
            'status' => $this->status ,
            'created_by' => $this->created_by ,
            'type' => $this->type
        ];
    }
}
