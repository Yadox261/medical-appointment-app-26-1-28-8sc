<x-admin-layout title="Nueva Cita" :breadcrumb="[
    ['name' => 'Dashboard',      'href' => route('admin.dashboard')],
    ['name' => 'Citas Médicas',  'href' => route('admin.appointments.index')],
    ['name' => 'Nuevo'],
]">

    @livewire('admin.appointment-wizard')

</x-admin-layout>
