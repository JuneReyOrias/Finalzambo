<?php

namespace App\Notifications;

use App\Models\Farmer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegisteredFarmer extends Notification
{
    use Queueable;

    protected $farmer;

    public function __construct(Farmer $farmer)
    {
        $this->farmer = $farmer;
    }

    // Specify the channels the notification will use
    public function via($notifiable)
    {
        return ['database']; // Using only database, but you can add 'mail' or other channels if needed
    }

    // Specify the data to store in the database
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new farmer has successfully registered.',
            
            'Agri-District' => $this->farmer->district,
           
            'updated_at' => now(),
        ];
    }
}
