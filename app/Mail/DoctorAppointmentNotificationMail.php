<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Appointment;
use Illuminate\Mail\Mailables\Attachment;

class DoctorAppointmentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfContent;
    public $upcomingAppointments;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $pdfContent = null, $upcomingAppointments = null)
    {
        $this->appointment = $appointment;
        $this->pdfContent = $pdfContent;
        $this->upcomingAppointments = $upcomingAppointments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Cita Agendada - Healthify',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.doctor_appointment_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->pdfContent) {
            $attachments[] = Attachment::fromData(fn () => $this->pdfContent, 'Comprobante_Cita.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
