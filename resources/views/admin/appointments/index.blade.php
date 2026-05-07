<x-admin-layout title="Citas Médicas" :breadcrumb="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Citas Médicas'],
]">
    <x-slot name="action">
        <a href="{{ route('admin.appointments.create') }}">
            <x-wire-button blue>
                <i class="fa-solid fa-plus mr-2"></i> Nueva Cita
            </x-wire-button>
        </a>
    </x-slot>

    @livewire('admin.datatables.appointment-table')

</x-admin-layout>
