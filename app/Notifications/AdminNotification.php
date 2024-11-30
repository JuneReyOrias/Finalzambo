<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\FarmProfile;
class AdminNotification extends Notification
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
            'message' => 'Agent Completed New Survey Form',
            'Agri-District' => $this->farmProfile->agri_districts,
            'updated_by' => auth()->user()->last_name, // Include the name of the person who made the update
            'updated_at' => now(),
        ];
    }
}
