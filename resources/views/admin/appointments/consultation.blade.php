<x-admin-layout title="Consulta" :breadcrumb="[
    ['name' => 'Dashboard',     'href' => route('admin.dashboard')],
    ['name' => 'Citas Médicas', 'href' => route('admin.appointments.index')],
    ['name' => 'Consulta'],
]">

    @livewire('admin.consultation-manager', ['appointment' => $appointment])

</x-admin-layout>
