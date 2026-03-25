<?php

namespace App\Livewire\Admin\Datatables;

// ESTAS DOS SON LAS IMPORTACIONES QUE TE FALTABAN:
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

class PatientTable extends DataTableComponent
{
    // Cambiamos buildQuery por builder (que es el nombre estándar del paquete)
    public function builder(): Builder
    {
        return Patient::query()
            ->with(['user', 'bloodtype']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Nombre', 'user.name')
                ->sortable()
                ->searchable(),
            Column::make('Correo', 'user.email')
                ->sortable()
                ->searchable(),
            Column::make('Número de id', 'user.id_number') // Asegúrate que id_number esté en la tabla users
                ->sortable()
                ->searchable(),
            Column::make('Telefono', 'user.phone')
                ->sortable()
                ->searchable(),
            Column::make('Tipo de sangre', 'bloodtype.name')
                ->sortable()
                ->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.patients.actions', ['patient' => $row])),
        ];
    }

    // Los métodos delete, edit, show, etc., pueden quedarse aquí abajo
    public function delete($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        // Nota: En Livewire 3 se usa $this->dispatch()
        $this->dispatch('notify', type: 'success', text: 'El paciente se eliminó correctamente');
    }
}