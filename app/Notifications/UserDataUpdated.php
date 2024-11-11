<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FarmProfile;

class UserDataUpdated extends Notification
{
    use Queueable;

    protected $farmProfile;

    public function __construct(FarmProfile $farmProfile)
    {
        $this->farmProfile = $farmProfile;
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
            'message' => 'You Farm Profile Data is Updated',
            'farm_profile_id' => $this->farmProfile->id,
            'updated_by' => auth()->user()->last_name, // Include the name of the person who made the update
            'updated_at' => now(),
        ];
    }
}
