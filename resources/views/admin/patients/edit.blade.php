<x-admin-layout title="Editar" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index')
    ],
    [
        'name' => 'Editar',
    ] 
    ]">
 
</x-admin-layout>