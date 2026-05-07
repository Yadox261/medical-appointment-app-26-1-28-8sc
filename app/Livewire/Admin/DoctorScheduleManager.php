<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Livewire\Component;

class DoctorScheduleManager extends Component
{
    public Doctor $doctor;

    // Slots seleccionados como array de strings "day|HH:MM"
    public array $selectedSlots = [];

    // Días de la semana
    public array $days = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    // Slots de tiempo (generados en mount)
    public array $timeSlots = [];

    public function mount(Doctor $doctor): void
    {
        $this->doctor = $doctor;

        // Generar slots de 08:00 a 19:45 cada 15 minutos
        $start = strtotime('08:00');
        $end   = strtotime('20:00');
        for ($t = $start; $t < $end; $t += 15 * 60) {
            $this->timeSlots[] = date('H:i', $t);
        }

        // Cargar horario existente del doctor
        $this->selectedSlots = DoctorSchedule::where('doctor_id', $doctor->id)
            ->get()
            ->map(fn($s) => $s->day_of_week . '|' . substr($s->time_slot, 0, 5))
            ->toArray();
    }

    /**
     * Llamado desde Alpine.js con el array de slots seleccionados
     */
    public function saveSchedule(array $slots): void
    {
        // Limpiar horario anterior
        DoctorSchedule::where('doctor_id', $this->doctor->id)->delete();

        // Insertar los nuevos slots seleccionados
        foreach ($slots as $slot) {
            if (!str_contains($slot, '|')) continue;
            [$day, $time] = explode('|', $slot);
            DoctorSchedule::create([
                'doctor_id'   => $this->doctor->id,
                'day_of_week' => (int) $day,
                'time_slot'   => $time . ':00',
            ]);
        }

        session()->flash('swal', [
            'title' => '¡Horario guardado!',
            'text'  => 'El horario del Dr. ' . $this->doctor->user->name . ' fue actualizado correctamente.',
            'icon'  => 'success',
        ]);

        $this->redirect(route('admin.doctors.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule-manager');
    }
}
