<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Carbon\Carbon;
use Livewire\Component;

class AppointmentWizard extends Component
{
    // Search Fields
    public $searchDate;
    public $searchTimeRange;
    public $searchSpecialty;

    // Available Options
    public $timeRanges = [];
    public $specialties = [];
    public $patients = [];

    // Search Results
    public $availableDoctors = [];

    // Selection
    public $selectedDoctorId = null;
    public $selectedTimeSlot = null;

    // Form Data
    public $patientId = null;
    public $reason = '';

    public function mount()
    {
        $this->searchDate = date('Y-m-d');
        
        // Generar rangos de horas (de 08:00 a 19:00)
        for ($i = 8; $i <= 19; $i++) {
            $start = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
            $end = str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ':00:00';
            $this->timeRanges[] = $start . ' - ' . $end;
        }
        
        $this->searchTimeRange = $this->timeRanges[0];
        $this->specialties = Doctor::whereNotNull('specialty')->distinct()->pluck('specialty')->toArray();
        $this->patients = Patient::with('user')->get()->sortBy('user.name');
    }

    public function searchAvailability()
    {
        $this->reset(['availableDoctors', 'selectedDoctorId', 'selectedTimeSlot']);
        $this->validate([
            'searchDate' => 'required|date|after_or_equal:today',
            'searchTimeRange' => 'required',
        ]);

        $date = Carbon::parse($this->searchDate);
        $dayOfWeek = $date->dayOfWeekIso; // 1 = Lunes, 7 = Domingo

        if ($dayOfWeek == 7) {
            return; // No hay citas los domingos
        }

        [$startTime, $endTime] = explode(' - ', $this->searchTimeRange);

        $query = Doctor::with('user');
        if (!empty($this->searchSpecialty)) {
            $query->where('specialty', $this->searchSpecialty);
        }
        $doctors = $query->get();

        foreach ($doctors as $doctor) {
            // Slots disponibles del doctor
            $slots = DoctorSchedule::where('doctor_id', $doctor->id)
                ->where('day_of_week', $dayOfWeek)
                ->where('time_slot', '>=', $startTime)
                ->where('time_slot', '<', $endTime)
                ->orderBy('time_slot')
                ->pluck('time_slot')
                ->toArray();

            if (count($slots) > 0) {
                // Citas ocupadas
                $bookedSlots = Appointment::where('doctor_id', $doctor->id)
                    ->whereDate('date', $this->searchDate)
                    ->whereIn('status', [1, 2]) // 1=Programado, 2=Completado
                    ->pluck('start_time')
                    ->map(fn($t) => Carbon::parse($t)->format('H:i:s'))
                    ->toArray();

                $freeSlots = array_diff($slots, $bookedSlots);

                if (count($freeSlots) > 0) {
                    $this->availableDoctors[] = [
                        'doctor' => $doctor,
                        'slots' => array_values($freeSlots)
                    ];
                }
            }
        }
    }

    public function selectSlot($doctorId, $timeSlot)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedTimeSlot = $timeSlot;
        
        // Reset validaciones si hubieran
        $this->resetErrorBag();
    }

    public function confirmAppointment()
    {
        $this->validate([
            'selectedDoctorId' => 'required',
            'selectedTimeSlot' => 'required',
            'searchDate'       => 'required|date|after_or_equal:today',
            'patientId'        => 'required',
            'reason'           => 'nullable|string|max:1000',
        ]);

        $endTime = Carbon::parse($this->selectedTimeSlot)->addMinutes(15)->format('H:i:s');

        Appointment::create([
            'patient_id' => $this->patientId,
            'doctor_id'  => $this->selectedDoctorId,
            'date'       => $this->searchDate,
            'start_time' => $this->selectedTimeSlot,
            'end_time'   => $endTime,
            'duration'   => 15,
            'reason'     => $this->reason,
            'status'     => 1,
        ]);

        session()->flash('swal', [
            'title' => '¡Cita confirmada!',
            'text'  => 'La cita ha sido agendada correctamente.',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.appointment-wizard');
    }
}
