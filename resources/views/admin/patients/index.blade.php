<x-admin-layout title="Pacientes" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Pacientes',
    ],
    ]">
    
 @livewire('admin.datatables.patient-table')
 
</x-admin-layout>