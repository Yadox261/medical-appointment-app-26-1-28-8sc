<x-admin-layout title="Doctores" :breadcrumb="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Doctores'],
]">
    <x-slot name="action">
        <a href="{{ route('admin.doctors.create') }}">
            <x-wire-button blue>
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Doctor
            </x-wire-button>
        </a>
    </x-slot>

    @livewire('admin.datatables.doctor-table')

</x-admin-layout>
