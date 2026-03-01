<x-admin-layout title="Editar" :breadcrumb="[
    [
        'name' => 'Dashboard', 
        'href' => route('admin.dashboard')

    ],
    [
        'name' => 'Roles y Permisos',
        'href' => route('admin.roles.index')
    ],
    [
        'name' => 'Editar',
    ] 
    ]">
    <x-wire-card>
       <form action="{{route('admin.roles.update', $role)}}" method="POST">
        @csrf
        @method('PUT')
        <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{old('name', $role->name) }}"></x-wire-input>
        <div flex justify-end mt-4>
            <x-wire-button blue type="submit" mt-4> Actualizar</x-wire-button>
        </div>
       </form>
    </x-wire-card>
</x-admin-layout>