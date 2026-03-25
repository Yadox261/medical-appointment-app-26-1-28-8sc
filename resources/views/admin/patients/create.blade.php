<x-admin-layout title="Crear" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index')
    ],
    [
        'name' => 'Crear',
    ] 
    ]">

</x-admin-layout>