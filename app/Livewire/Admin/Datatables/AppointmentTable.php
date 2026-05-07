<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy  = 'date';
    public string $sortDir = 'desc';

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $column;
            $this->sortDir = 'asc';
        }
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Appointment::findOrFail($id)->delete();
        session()->flash('message', 'Cita eliminada correctamente.');
    }

    public function render()
    {
        $appointments = Appointment::query()
            ->with(['patient.user', 'doctor.user'])
            ->when($this->search, function (Builder $q) {
                $q->whereHas('patient.user', fn($u) =>
                        $u->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('doctor.user', fn($u) =>
                        $u->where('name', 'like', '%' . $this->search . '%'));
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        return view('livewire.admin.datatables.appointment-table', compact('appointments'));
    }
}
