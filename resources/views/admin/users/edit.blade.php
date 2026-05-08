<x-admin-layout :breadcrumb="[
    ['name' => 'Usuarios', 'href' => route('admin.users.index')],
    ['name' => 'Editar usuario', 'href' => route('admin.users.edit', $user)]
]">
<div class="p-4 max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-heading">Editar usuario</h1>
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <div class="bg-white rounded-xl border border-default p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('name') ? 'border-red-500' : '' }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('email') ? 'border-red-500' : '' }}">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono con Código de País --}}
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <div class="flex">
                    <select name="country_code" id="country_code"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-l-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 border-r-0">
                        <option value="+52" {{ old('country_code', $user->country_code ?? '+52') == '+52' ? 'selected' : '' }}>🇲🇽 +52</option>
                        <option value="+1" {{ old('country_code', $user->country_code) == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+34" {{ old('country_code', $user->country_code) == '+34' ? 'selected' : '' }}>🇪🇸 +34</option>
                        <option value="+54" {{ old('country_code', $user->country_code) == '+54' ? 'selected' : '' }}>🇦🇷 +54</option>
                        <option value="+57" {{ old('country_code', $user->country_code) == '+57' ? 'selected' : '' }}>🇨🇴 +57</option>
                        <option value="+56" {{ old('country_code', $user->country_code) == '+56' ? 'selected' : '' }}>🇨🇱 +56</option>
                        <option value="+51" {{ old('country_code', $user->country_code) == '+51' ? 'selected' : '' }}>🇵🇪 +51</option>
                    </select>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="1234567890"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('phone') ? 'border-red-500' : '' }}">
                </div>
                @error('country_code')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                @error('phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Número de Identificación --}}
            <div class="mb-4">
                <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">Número de ID / Documento</label>
                <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $user->id_number) }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('id_number') ? 'border-red-500' : '' }}">
                @error('id_number')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dirección --}}
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('address') ? 'border-red-500' : '' }}">
                @error('address')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Nueva contraseña
                    <span class="text-xs text-gray-400 font-normal">(dejar en blanco para no cambiar)</span>
                </label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('password') ? 'border-red-500' : '' }}">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmar Contraseña --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña</label>
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
                                {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'checked' : '' }}
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
                    Actualizar usuario
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>