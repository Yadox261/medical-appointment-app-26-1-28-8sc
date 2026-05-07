<x-admin-layout title="Editar Cita" :breadcrumb="[
    ['name' => 'Dashboard',     'href' => route('admin.dashboard')],
    ['name' => 'Citas Médicas', 'href' => route('admin.appointments.index')],
    ['name' => 'Editar'],
]">

<form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="mt-4">
    @csrf
    @method('PUT')

    <x-wire-card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-700">
                <i class="fa-solid fa-calendar-pen mr-2 text-blue-500"></i>
                Editar Cita #{{ $appointment->id }}
            </h2>
            <div class="flex gap-3">
                <x-wire-button outline gray href="{{ route('admin.appointments.index') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </x-wire-button>
                <x-wire-button blue type="submit">
                    <i class="fa-solid fa-check mr-2"></i> Actualizar
                </x-wire-button>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            {{-- Paciente --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Paciente <span class="text-red-500">*</span>
                </label>
                <select name="patient_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                               @error('patient_id') border-red-500 @enderror">
                    <option value="">— Seleccione un paciente —</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            @selected(old('patient_id', $appointment->patient_id) == $patient->id)>
                            {{ $patient->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Doctor --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Doctor <span class="text-red-500">*</span>
                </label>
                <select name="doctor_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                               @error('doctor_id') border-red-500 @enderror">
                    <option value="">— Seleccione un doctor —</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            @selected(old('doctor_id', $appointment->doctor_id) == $doctor->id)>
                            {{ $doctor->user->name }}
                            @if($doctor->specialty) — {{ $doctor->specialty }} @endif
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date"
                       value="{{ old('date', $appointment->date->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                              @error('date') border-red-500 @enderror">
                @error('date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select name="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                               @error('status') border-red-500 @enderror">
                    <option value="1" @selected(old('status', $appointment->status) == 1)>Programado</option>
                    <option value="2" @selected(old('status', $appointment->status) == 2)>Completado</option>
                    <option value="3" @selected(old('status', $appointment->status) == 3)>Cancelado</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hora de inicio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Hora de inicio <span class="text-red-500">*</span>
                </label>
                <input type="time" name="start_time"
                       value="{{ old('start_time', $appointment->start_time) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                              @error('start_time') border-red-500 @enderror">
                @error('start_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hora de fin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Hora de fin <span class="text-red-500">*</span>
                </label>
                <input type="time" name="end_time"
                       value="{{ old('end_time', $appointment->end_time) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                              @error('end_time') border-red-500 @enderror">
                @error('end_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Motivo --}}
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita</label>
                <textarea name="reason" rows="3"
                          placeholder="Motivo de la cita..."
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400
                                 @error('reason') border-red-500 @enderror">{{ old('reason', $appointment->reason) }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </x-wire-card>

</form>

</x-admin-layout>
