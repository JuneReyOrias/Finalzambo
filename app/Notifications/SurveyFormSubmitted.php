<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SurveyFormSubmitted extends Notification
{
    private $farmProfile;
    private $creator;

    public function __construct($farmProfile, $creator)
    {
        $this->farmProfile = $farmProfile;
        $this->creator = $creator; // Agent who created the survey
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Use additional channels as needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Survey Created by ' . $this->creator->name)
            ->line('A new survey has been submitted by ' . $this->creator->name . '.')
            ->line('Survey Details:')
            ->line('Farm Address: ' . $this->farmProfile->farm_address)
            ->action('View Survey', url('/surveys/' . $this->farmProfile->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'farm_profile_id' => $this->farmProfile->id,
            'creator_name' => $this->creator->last_name,
            'message' => 'A new survey has been submitted by ' . $this->creator->last_name . '.',
        ];
    }
}