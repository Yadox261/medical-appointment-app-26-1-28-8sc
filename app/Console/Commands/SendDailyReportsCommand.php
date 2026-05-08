<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\User;
use App\Mail\DailyAdminReportMail;
use App\Mail\DailyDoctorReportMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDailyReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía reportes diarios por correo al administrador y a los doctores sobre las citas del día.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $today)
            ->whereIn('status', [1, 2]) // 1=Programada, 2=Completada
            ->orderBy('start_time')
            ->get();

        if (!$appointments->isEmpty()) {
            // 1. Enviar reporte general al administrador (solo si hay citas)
            $admin = null;
            try {
                $admin = User::role('admin')->first();
            } catch (\Exception $e) {
                // Si el rol no existe, usar el primer usuario del sistema como admin fallback
                $admin = User::find(1);
            }
            
            $adminEmail = $admin ? $admin->email : config('mail.from.address');
            
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new DailyAdminReportMail($appointments));
                $this->info("Reporte general enviado al admin ({$adminEmail}).");
                sleep(15); // Pausa LARGA para evitar el bloqueo total de Mailtrap
            }
        } else {
            $this->info("No hay citas programadas para hoy, omitiendo reporte general de administrador.");
        }

        // 2. Obtener a TODOS los doctores para enviarles su reporte
        $doctors = \App\Models\Doctor::with('user')->get();
        $appointmentsByDoctor = $appointments->groupBy('doctor_id');

        foreach ($doctors as $doctor) {
            $doctorUser = $doctor->user;
            
            if ($doctorUser && $doctorUser->email) {
                try {
                    // Verificar si este doctor tiene citas hoy
                    if ($appointmentsByDoctor->has($doctor->id)) {
                        // Sí tiene citas
                        $doctorAppointments = $appointmentsByDoctor->get($doctor->id);
                        Mail::to($doctorUser->email)->send(new DailyDoctorReportMail($doctorAppointments, $doctorUser));
                        $this->info("Reporte con citas enviado al doctor {$doctorUser->name}.");
                    } else {
                        // No tiene citas
                        Mail::to($doctorUser->email)->send(new \App\Mail\DailyDoctorNoAppointmentsMail($doctorUser));
                        $this->info("Reporte de DÍA LIBRE enviado al doctor {$doctorUser->name}.");
                    }
                    sleep(15); // Pausa obligatoria larga por restricciones de Mailtrap
                } catch (\Exception $e) {
                    $this->error("Error al enviar correo al Dr. {$doctorUser->name}: " . $e->getMessage());
                }
            }
        }

        Log::info("Reportes diarios enviados para la fecha {$today}. Total de citas: {$appointments->count()}");
    }
}
