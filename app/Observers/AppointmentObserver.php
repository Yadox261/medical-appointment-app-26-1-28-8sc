<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Mail\AppointmentReceiptMail;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        // Cargar las relaciones necesarias
        $appointment->load(['patient.user', 'doctor.user']);

        // 1. Generar el PDF
        $pdfContent = null;
        try {
            $pdf = Pdf::loadView('pdfs.appointment_receipt', compact('appointment'));
            $pdfContent = $pdf->output();
        } catch (\Exception $e) {
            Log::error('Error al generar el PDF del comprobante: ' . $e->getMessage());
        }

        // 2. Enviar correo al paciente y al doctor
        $patientEmail = $appointment->patient->user->email;
        $doctorEmail = $appointment->doctor->user->email;

        if ($pdfContent) {
            try {
                if ($patientEmail) {
                    Mail::to($patientEmail)->send(new \App\Mail\AppointmentReceiptMail($appointment, $pdfContent));
                    sleep(10); // Mailtrap es muy estricto: Pausa de 10 segundos
                }
            } catch (\Exception $e) {
                Log::error('Error al enviar correo al paciente: ' . $e->getMessage());
            }

            // (Desactivado temporalmente) Enviar correo al doctor al instante
            /*
            try {
                if ($doctorEmail) {
                    $upcomingAppointments = Appointment::with('patient.user')
                        ->where('doctor_id', $appointment->doctor_id)
                        ->where('date', '>=', now()->toDateString())
                        ->where('status', 1) // 1 = Programada
                        ->orderBy('date')
                        ->orderBy('start_time')
                        ->get();

                    Mail::to($doctorEmail)->send(new \App\Mail\DoctorAppointmentNotificationMail($appointment, $pdfContent, $upcomingAppointments));
                }
            } catch (\Exception $e) {
                Log::error('Error al enviar correo al doctor: ' . $e->getMessage());
            }
            */
        }

        // 3. Enviar WhatsApp al paciente
        try {
            $patientUser = $appointment->patient->user;
            $patientPhone = $patientUser->country_code . $patientUser->phone;
            if ($patientUser->phone) {
                $whatsappService = new WhatsAppService();
                $message = "Hola {$appointment->patient->user->name}, tu cita con el Dr. {$appointment->doctor->user->name} ha sido agendada para el " . 
                           \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') . " a las {$appointment->start_time}.";
                $whatsappService->sendMessage($patientPhone, $message);
            }
        } catch (\Exception $e) {
            Log::error('Error al enviar WhatsApp simulado: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
