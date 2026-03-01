<x-admin-layout title="Crear" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Roles y Permisos',
        'href' => route('admin.roles.index')
    ],
    [
        'name' => 'Crear',
    ] 
    ]">
    <x-wire-card>
       <form action="{{route('admin.roles.store')}}" method="POST">
        @csrf
        <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{old('name') }}"></x-wire-input>
        <div flex justify-end mt-4>
            <x-wire-button blue type="submit" mt-4> Guardar</x-wire-button>
        </div>
       </form>
    </x-wire-card>
</x-admin-layout>