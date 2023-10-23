<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddEmployeeNotification extends Notification
{
    use Queueable;

    private $emp_id;
    private $user_create_emp;
    private $employee_name;
    private $type;
    // ++++++++++++++++++++ __construct() ++++++++++++++++++++
    public function __construct($emp_id,$user_create_emp,$employee_name,$type)
    {
        $this->emp_id = $emp_id;
        $this->employee_name = $employee_name ;
        $this->user_create_emp = $user_create_emp;
        $this->type = $type;
    }
    // ++++++++++++++++++++ via() ++++++++++++++++++++
    public function via($notifiable)
    {
        return ['database'];
    }
    // ++++++++++++++++++++ toMail() ++++++++++++++++++++
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    // ++++++++++++++++++++ toArray() ++++++++++++++++++++
    public function toArray($notifiable)
    {
        return [
            'emp_id' => $this->emp_id,
            'employee_name' => $this->employee_name,
            'type' => $this->type,
            'created_by' => $this->user_create_emp,
        ];
    }
}
