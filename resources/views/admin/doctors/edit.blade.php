<x-admin-layout title="Editar Doctor" :breadcrumb="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Doctores',  'href' => route('admin.doctors.index')],
    ['name' => 'Editar'],
]">

<form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="space-y-6 mt-4">
    @csrf
    @method('PUT')

    <x-wire-card>
        {{-- Header con avatar --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ $doctor->user->profile_photo_url }}"
                     class="w-16 h-16 rounded-full object-cover border-2 border-blue-300"
                     alt="{{ $doctor->user->name }}">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $doctor->user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $doctor->user->email }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <x-wire-button outline gray href="{{ route('admin.doctors.index') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </x-wire-button>
                <x-wire-button blue type="submit">
                    <i class="fa-solid fa-check mr-2"></i> Guardar
                </x-wire-button>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            {{-- Usuario --}}
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Usuario <span class="text-red-500">*</span>
                </label>
                <select name="user_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                               @error('user_id') border-red-500 @enderror">
                    <option value="">— Seleccione un usuario —</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            @selected(old('user_id', $doctor->user_id) == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Especialidad --}}
            <div>
                <x-wire-input
                    label="Especialidad *"
                    name="specialty"
                    placeholder="Ej: Cardiología, Pediatría..."
                    value="{{ old('specialty', $doctor->specialty) }}"
                />
                @error('specialty')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cédula --}}
            <div>
                <x-wire-input
                    label="Cédula Profesional"
                    name="cedula_profesional"
                    placeholder="Número de cédula (opcional)"
                    value="{{ old('cedula_profesional', $doctor->cedula_profesional) }}"
                />
                @error('cedula_profesional')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </x-wire-card>

</form>

</x-admin-layout>
