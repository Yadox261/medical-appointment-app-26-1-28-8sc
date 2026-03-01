<x-admin-layout title="Roles y Permisos" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Roles y Permisos',
    ],
    ]">
    
    <x-slot name="action">
        <x-wire-button href="{{ route('admin.roles.create') }}" blue>
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    <div class="w-full px-4 py-6">
        @livewire('admin.datatables.role-table')
    </div>
</x-admin-layout>