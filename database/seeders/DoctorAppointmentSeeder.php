<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================
        // 1. Crear usuarios de demostración: Doctores
        // =========================================
        $specialties = ['Cardiología', 'Pediatría', 'Endocrinología', 'Traumatología', 'Neurología'];
        $doctors = [];

        foreach ($specialties as $i => $specialty) {
            $user = User::create([
                'name'     => "Dr. Demo {$specialty}",
                'email'    => "doctor.{$i}@healthify.test",
                'password' => Hash::make('password'),
            ]);

            $doctors[] = Doctor::create([
                'user_id'            => $user->id,
                'specialty'          => $specialty,
                'cedula_profesional' => '12345' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }

        // =========================================
        // 2. Crear usuarios de demostración: Pacientes
        // =========================================
        $patients = Patient::all();

        // Si no hay pacientes, crear algunos de prueba
        if ($patients->isEmpty()) {
            for ($i = 1; $i <= 8; $i++) {
                $user = User::create([
                    'name'     => "Paciente Demo {$i}",
                    'email'    => "paciente.{$i}@healthify.test",
                    'password' => Hash::make('password'),
                ]);

                $patients[] = Patient::create([
                    'user_id' => $user->id,
                ]);
            }
            $patients = collect($patients);
        }

        // =========================================
        // 3. Crear citas de demostración
        // =========================================
        $statuses = [1, 1, 1, 2, 3]; // Mayoría programadas
        $reasons  = [
            'Chequeo general de rutina',
            'Revisión de resultados de laboratorio',
            'Dolor de cabeza persistente',
            'Control de presión arterial',
            'Seguimiento post-operatorio',
            'Consulta por fiebre y tos',
            'Evaluación de dolor lumbar',
            'Control de diabetes',
        ];

        $startDate = now()->subDays(30);

        for ($i = 0; $i < 15; $i++) {
            $date      = $startDate->copy()->addDays(rand(0, 60));
            $startHour = rand(8, 16);
            $startTime = sprintf('%02d:00:00', $startHour);
            $endTime   = sprintf('%02d:30:00', $startHour);
            $status    = $statuses[array_rand($statuses)];

            $appointment = Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id'  => $doctors[array_rand($doctors)]->id,
                'date'       => $date->format('Y-m-d'),
                'start_time' => $startTime,
                'end_time'   => $endTime,
                'duration'   => 30,
                'reason'     => $reasons[array_rand($reasons)],
                'status'     => $status,
            ]);

            // Para las citas completadas, crear consulta con receta
            if ($status === 2) {
                $consultation = Consultation::create([
                    'appointment_id' => $appointment->id,
                    'diagnosis'      => 'Diagnóstico de ejemplo. El paciente presenta síntomas compatibles con un cuadro leve. Se recomienda seguimiento en 2 semanas.',
                    'treatment'      => 'Reposo relativo. Hidratación adecuada. Dieta balanceada. No realizar esfuerzo físico intenso por 7 días.',
                    'notes'          => 'El paciente reporta mejoría respecto a la visita anterior. Sin complicaciones.',
                ]);

                Prescription::create([
                    'consultation_id' => $consultation->id,
                    'medication'      => 'Amoxicilina 500mg',
                    'dose'            => '1 cápsula cada 8 horas',
                    'frequency'       => 'por 7 días',
                ]);

                Prescription::create([
                    'consultation_id' => $consultation->id,
                    'medication'      => 'Paracetamol 500mg',
                    'dose'            => '1 tableta cada 6 horas',
                    'frequency'       => 'según sea necesario para el dolor',
                ]);
            }
        }

        $this->command->info('✅ DoctorAppointmentSeeder: Creados ' . count($doctors) . ' doctores y 15 citas de demostración.');
    }
}
