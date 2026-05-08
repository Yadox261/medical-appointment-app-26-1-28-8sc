<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendAppointmentRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un recordatorio de WhatsApp a los pacientes que tienen cita al día siguiente.';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $tomorrow)
            ->where('status', 1) // 1 = Programada
            ->get();

        $count = 0;

        foreach ($appointments as $appointment) {
            $patientUser = $appointment->patient->user;
            $patientPhone = $patientUser->country_code . $patientUser->phone;
            
            if ($patientUser->phone) {
                $message = "Recordatorio Healthify: Hola {$appointment->patient->user->name}, te recordamos que mañana tienes una cita médica con el Dr. {$appointment->doctor->user->name} a las {$appointment->start_time}. ¡Te esperamos!";
                
                $whatsappService->sendMessage($patientPhone, $message);
                $count++;
            }
        }

        $this->info("Recordatorios enviados: {$count}");
        Log::info("Comando de recordatorios ejecutado. Total enviados: {$count}");
    }
}
