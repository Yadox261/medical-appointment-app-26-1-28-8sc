<x-admin-layout :breadcrumb="[
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Nuevo usuario', 'href' => route('admin.users.create')]
]">
<div class="p-4 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-heading">Nuevo usuario</h1>
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <div class="bg-white rounded-xl border border-default p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('name') ? 'border-red-500' : '' }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('email') ? 'border-red-500' : '' }}">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('password') ? 'border-red-500' : '' }}">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar Contraseña --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            {{-- Roles --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Roles</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($roles as $role)
                        <label class="flex items-center gap-2 px-3 py-2 border border-gray-200 rounded-lg cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                class="accent-purple-600">
                            <span class="text-sm text-gray-700">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar usuario
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>