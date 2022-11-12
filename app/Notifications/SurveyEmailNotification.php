<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SurveyEmailNotification extends Notification
{
    use Queueable;

    public $url;
    public $institution_name;
    public $remaining_time;
    public $survey_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url, $institution_name, $survey_name, $remaining_time)
    {
        $this->url = $url;
        $this->delay(\now()->addSeconds(10));
        $this->institution_name = $institution_name;
        $this->remaining_time = $remaining_time;
        $this->survey_name = $survey_name;
        // $this->onQueue('email');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // dd($this->url)
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    // ->action('Enlace de la encuesta', $this->url)
                    ->subject('Encuesta: '.$this->survey_name)
                    ->markdown('vendor.mail.send_survey', ['url' => $this->url, 'institution_name' => $this->institution_name, 'remaining_time' => $this->remaining_time])
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
            //
        ];
    }
}
