<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // Tabla más ancha
        $this->setTableWrapperAttributes([
            'class' => 'w-full',
        ]);

        // Quitar el buscador, columnas y per-page de arriba si quieres
        $this->setSearchEnabled();
        $this->setPerPageAccepted([10, 25, 50, 100]);

        // Estilos de la tabla
        $this->setTableAttributes([
            'class' => 'w-full text-sm text-left text-gray-500',
        ]);

        // Estilos del thead
        $this->setTheadAttributes([
            'class' => 'text-xs text-white uppercase bg-gray-700',
        ]);

        // Estilos de las filas
        $this->setTrAttributes(function ($row, $index) {
            return [
                'class' => 'bg-white border-b hover:bg-gray-50',
            ];
        });

        // Estilos de las celdas
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            return [
                'class' => 'px-6 py-4',
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable(),
            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('d/m/Y')),
            Column::make("Acciones")
            ->label(function ($row, Column $column) {
                return view('admin.roles.actions', ['role' => $row]);
            })
        ];
    }
}
