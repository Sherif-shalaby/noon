<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckExipryNotification extends Notification
{
    use Queueable;
    // +++++++++++++++++++ private variables +++++++++++++++++++
    private $user_id , $product_id , $qty_available ,
            $alert_quantity , $days , $status ,
            $created_by , $type;
    // +++++++++++++++++++ constructor +++++++++++++++++++
    public function __construct( $user_id,$product_id , $qty_available ,
                                $alert_quantity , $days , $status ,
                                $created_by , $type)
    {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->qty_available = $qty_available ;
        $this->alert_quantity = $alert_quantity ;
        $this->days = $days ;
        $this->status = $status ;
        $this->created_by = $created_by ;
        $this->type = $type;
    }
    // +++++++++++++++++++++++ via() +++++++++++++++++++++++
    public function via($notifiable)
    {
        // return ['mail'];
        return ['database'];
    }
    // +++++++++++++++++++++++ toMail() +++++++++++++++++++++++
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    // +++++++++++++++++++++++ toArray() +++++++++++++++++++++++
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user_id ,
            'product_id' => $this->product_id ,
            'qty_available' => $this->qty_available ,
            'alert_quantity' => $this->alert_quantity ,
            'days' => $this->days ,
            'status' => $this->status ,
            'created_by' => $this->created_by ,
            'type' => $this->type
        ];
    }
}
