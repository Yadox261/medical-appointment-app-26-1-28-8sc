<x-admin-layout title="Nuevo Doctor" :breadcrumb="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Doctores',  'href' => route('admin.doctors.index')],
    ['name' => 'Nuevo'],
]">

<form action="{{ route('admin.doctors.store') }}" method="POST" class="space-y-6 mt-4">
    @csrf

    <x-wire-card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-700">
                <i class="fa-solid fa-user-doctor mr-2 text-blue-500"></i> Datos del Doctor
            </h2>
            <div class="flex gap-3">
                <x-wire-button outline gray href="{{ route('admin.doctors.index') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar
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
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
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
                    value="{{ old('specialty') }}"
                />
                @error('specialty')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cédula Profesional --}}
            <div>
                <x-wire-input
                    label="Cédula Profesional"
                    name="cedula_profesional"
                    placeholder="Número de cédula (opcional)"
                    value="{{ old('cedula_profesional') }}"
                />
                @error('cedula_profesional')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </x-wire-card>

</form>

</x-admin-layout>
