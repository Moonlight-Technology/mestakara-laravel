<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Reservation Received')
                    ->line('A new reservation has been received:')
                    ->line('Reservation ID: ' . $this->reservation['reservation_id'])
                    ->line('Guest Name: ' . $this->reservation['guest_name'])
                    ->line('Check-in: ' . $this->reservation['check_in'])
                    ->line('Check-out: ' . $this->reservation['check_out'])
                    ->line('Hotel Code: ' . $this->reservation['hotel_code'])
                    ->line('Room Code: ' . $this->reservation['room_code']);
    }
}
