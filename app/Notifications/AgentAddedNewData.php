<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Crop;
use App\Models\FarmProfile;

class AgentAddedNewData extends Notification
{
    use Queueable;

    protected $CropFarmLocation;

    public function __construct(Crop $CropFarmLocation)
    {
        $this->CropFarmLocation = $CropFarmLocation;
    }

    public function via($notifiable)
    {
        return ['database']; // The notification will only be stored in the database
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Admin Updated Crop And Farm location',
            'extend' => 'Based on your assign agri-District',
            'Crop' => $this->CropFarmLocation->crop_name,
            'updated_by' => auth()->user()->last_name, // Make sure the current user is authenticated
            'updated_at' => now(),
        ];
    }
}
