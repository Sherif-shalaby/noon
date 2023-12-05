<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddPurchaseOrderNotification extends Notification
{
    use Queueable;
    private $purchase_order_id;
    private $purchase_order_transaction_id;
    private $purchase_order_num;
    private $user_create_po;
    private $type;
    // ++++++++++++++++++++++++++++ __construct() ++++++++++++++++++++++++++++
    public function __construct($purchase_order_id,$purchase_order_transaction_id,$purchase_order_num,$user_create_po,$type)
    {
        $this->purchase_order_id   = $purchase_order_id;
        $this->purchase_order_transaction_id   = $purchase_order_transaction_id;
        $this->purchase_order_num  = $purchase_order_num;
        $this->user_create_po     = $user_create_po;
        $this->type = $type;
    }
    /* +++++++++++++++++ via() +++++++++++++++++ */
    public function via($notifiable)
    {
        return ['database'];
    }
    /* +++++++++++++++++ toMail() +++++++++++++++++ */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    /* +++++++++++++++++ toArray() +++++++++++++++++ */
    public function toArray($notifiable)
    {
        return [
            'purchase_order_id' => $this->purchase_order_id,
            'purchase_order_transaction_id' => $this->purchase_order_transaction_id,
            'purchase_order_num' => $this->purchase_order_num,
            'user_create_po' => $this->user_create_po,
            'type' => $this->type,
        ];
    }
}
