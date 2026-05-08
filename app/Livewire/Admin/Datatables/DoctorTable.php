<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy  = 'users.name';
    public string $sortDir = 'asc';

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
        Doctor::findOrFail($id)->delete();
        session()->flash('message', 'Doctor eliminado correctamente.');
    }

    public function render()
    {
        $doctors = Doctor::query()
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->select('doctors.*', 'users.name', 'users.email', 'users.id_number')
            ->when($this->search, function (Builder $q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                  ->orWhere('users.email', 'like', '%' . $this->search . '%')
                  ->orWhere('doctors.specialty', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        return view('livewire.admin.datatables.doctor-table', compact('doctors'));
    }
}
