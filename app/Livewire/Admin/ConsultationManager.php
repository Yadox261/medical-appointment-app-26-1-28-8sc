<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;

    // Tab activa
    public string $activeTab = 'consulta';

    // Campos de la consulta
    public string $diagnosis  = '';
    public string $treatment  = '';
    public string $notes      = '';

    // Medicamentos de la receta (array dinámico)
    public array $medications = [];

    // Control de modales
    public bool $showPastConsultations = false;

    // Consultas anteriores del paciente
    public $pastConsultations = [];

    public function mount(Appointment $appointment): void
    {
        $this->appointment = $appointment->load([
            'patient.user',
            'patient.bloodtype',
            'doctor.user',
            'consultation.prescriptions',
        ]);

        // Si ya existe consulta, pre-cargar datos
        if ($this->appointment->consultation) {
            $this->diagnosis = $this->appointment->consultation->diagnosis ?? '';
            $this->treatment = $this->appointment->consultation->treatment ?? '';
            $this->notes     = $this->appointment->consultation->notes ?? '';

            $this->medications = $this->appointment->consultation->prescriptions
                ->map(fn($p) => [
                    'medication' => $p->medication,
                    'dose'       => $p->dose,
                    'frequency'  => $p->frequency ?? '',
                ])->toArray();
        }

        if (empty($this->medications)) {
            $this->medications = [['medication' => '', 'dose' => '', 'frequency' => '']];
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function addMedication(): void
    {
        $this->medications[] = ['medication' => '', 'dose' => '', 'frequency' => ''];
    }

    public function removeMedication(int $index): void
    {
        array_splice($this->medications, $index, 1);

        if (empty($this->medications)) {
            $this->medications = [['medication' => '', 'dose' => '', 'frequency' => '']];
        }
    }



    public function openPastConsultations(): void
    {
        // Cargar consultas anteriores del paciente (excepto la actual)
        $this->pastConsultations = Appointment::with(['consultation.prescriptions', 'doctor.user'])
            ->where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->whereHas('consultation')
            ->orderByDesc('date')
            ->get();

        $this->showPastConsultations = true;
    }

    public function closePastConsultations(): void
    {
        $this->showPastConsultations = false;
    }

    public function saveConsultation(): void
    {
        $this->validate([
            'diagnosis'                    => 'nullable|string',
            'treatment'                    => 'nullable|string',
            'notes'                        => 'nullable|string',
            'medications.*.medication'     => 'required_with:medications.*.dose|string|max:255',
            'medications.*.dose'           => 'nullable|string|max:255',
            'medications.*.frequency'      => 'nullable|string|max:255',
        ]);

        // Crear o actualizar la consulta
        $consultation = Consultation::updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis' => $this->diagnosis ?: null,
                'treatment' => $this->treatment ?: null,
                'notes'     => $this->notes ?: null,
            ]
        );

        // Eliminar recetas anteriores y volver a insertar
        $consultation->prescriptions()->delete();

        foreach ($this->medications as $med) {
            if (!empty($med['medication'])) {
                Prescription::create([
                    'consultation_id' => $consultation->id,
                    'medication'      => $med['medication'],
                    'dose'            => $med['dose'] ?? '',
                    'frequency'       => $med['frequency'] ?? null,
                ]);
            }
        }

        // Marcar la cita como completada
        $this->appointment->update(['status' => 2]);

        session()->flash('swal', [
            'title' => '¡Consulta guardada!',
            'text'  => 'Los datos de la consulta fueron registrados correctamente.',
            'icon'  => 'success',
        ]);

        $this->redirect(route('admin.appointments.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
