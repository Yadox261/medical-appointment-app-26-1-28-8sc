@php
    $errorGroups = [
        'antecedentes'       => ['allergies', 'chronic_diseases', 'family_history', 'surgical_history'],
        'informacion-general'=> ['bloodtype_id', 'weight', 'height', 'observations'],
        'contacto-emergencia'=> ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
    ];

    $initialTab = 'datos-personales';
    foreach ($errorGroups as $tabName => $fields) {
        if ($errors->hasAny($fields)) {
            $initialTab = $tabName;
            break;
        }
    }
@endphp

<x-admin-layout title="Editar" :breadcrumb="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
    ['name' => 'Editar'],
]">

<form action="{{ route('admin.patients.update', $patient) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <x-wire-card>
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center">
                <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}" class="w-20 h-20 rounded-full mr-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 leading-tight">{{ $patient->user->name }}</h2>
                    <p class="text-gray-600">{{ $patient->user->email }}</p>
                </div>
            </div>
            <div class="flex gap-3 ml-6 shrink-0">
                <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </x-wire-button>
                <x-wire-button blue type="submit">
                    <i class="fa-solid fa-check mr-2"></i> Guardar
                </x-wire-button>
            </div>
        </div>
    </x-wire-card>

    <x-wire-card>
        <x-tabs
            :active="$initialTab"
            :errors-antecedentes="$errors->hasAny($errorGroups['antecedentes'])"
            :errors-info-general="$errors->hasAny($errorGroups['informacion-general'])"
            :errors-contacto="$errors->hasAny($errorGroups['contacto-emergencia'])">

            {{-- Menú de tabs --}}
            <x-slot name="header">

                {{-- Tab 1: Datos Personales --}}
                <x-tabs-link tab="datos-personales">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </x-slot>
                    Datos Personales
                </x-tabs-link>

                {{-- Tab 2: Antecedentes --}}
                <x-tabs-link tab="antecedentes" :has-errors="$errors->hasAny($errorGroups['antecedentes'])">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    Antecedentes
                </x-tabs-link>

                {{-- Tab 3: Información General --}}
                <x-tabs-link tab="informacion-general" :has-errors="$errors->hasAny($errorGroups['informacion-general'])">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                        </svg>
                    </x-slot>
                    Información General
                </x-tabs-link>

                {{-- Tab 4: Contacto de Emergencia --}}
                <x-tabs-link tab="contacto-emergencia" :has-errors="$errors->hasAny($errorGroups['contacto-emergencia'])">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z"/>
                            <path d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z"/>
                        </svg>
                    </x-slot>
                    Contacto de Emergencia
                </x-tabs-link>

            </x-slot>

            {{-- Contenido de tabs --}}

            {{-- Tab 1 --}}
            <x-tabs-content tab="datos-personales">
                <x-wire-alert shadow="none" padding="none">
                    <x-slot name="slot">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                <div class="flex items-center flex-1">
                                    <div class="flex-shrink-0">
                                        <svg class="w-16 h-16 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-bold text-blue-800">Edición de cuenta de usuario</h3>
                                        <p class="text-sm leading-relaxed text-blue-800">
                                            La <strong>información personal</strong> del paciente debe gestionarse desde la cuenta de usuario asociada.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-auto">
                                    <x-wire-button blue sm icon="pencil" :href="route('admin.users.edit', $patient->user)" label="Editar Usuario" target="_blank"/>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-wire-alert>
                <div class="grid lg:grid-cols-2 gap-4 mt-4">
                    <div><span class="text-gray-600 font-semibold"><strong>Nombre: </strong> {{ $patient->user->name }}</span></div>
                    <div><span class="text-gray-600 font-semibold"><strong>Email: </strong> {{ $patient->user->email }}</span></div>
                    <div><span class="text-gray-600 font-semibold"><strong>Teléfono: </strong> {{ $patient->user->phone }}</span></div>
                </div>
            </x-tabs-content>

            {{-- Tab 2 --}}
            <x-tabs-content tab="antecedentes">
                <div class="grid lg:grid-cols-2 gap-4">
                    <div x-data="{ texto: '{{ old('allergies', $patient->allergies) }}', limite: 300 }">
                        <x-wire-textarea label="Alergias Conocidas" name="allergies" x-model="texto" maxlength="300">{{ old('allergies', $patient->allergies) }}</x-wire-textarea>
                        <p class="text-sm mt-1 text-right" :class="texto.length >= limite ? 'text-red-500 font-semibold' : 'text-gray-400'">
                            <span x-text="texto.length"></span> / <span x-text="limite"></span>
                        </p>
                    </div>
                    <div x-data="{ texto: '{{ old('chronic_diseases', $patient->chronic_diseases) }}', limite: 300 }">
                        <x-wire-textarea label="Enfermedades Crónicas" name="chronic_diseases" x-model="texto" maxlength="300">{{ old('chronic_diseases', $patient->chronic_diseases) }}</x-wire-textarea>
                        <p class="text-sm mt-1 text-right" :class="texto.length >= limite ? 'text-red-500 font-semibold' : 'text-gray-400'">
                            <span x-text="texto.length"></span> / <span x-text="limite"></span>
                        </p>
                    </div>
                    <div x-data="{ texto: '{{ old('family_history', $patient->family_history) }}', limite: 300 }">
                        <x-wire-textarea label="Antecedentes familiares" name="family_history" x-model="texto" maxlength="300">{{ old('family_history', $patient->family_history) }}</x-wire-textarea>
                        <p class="text-sm mt-1 text-right" :class="texto.length >= limite ? 'text-red-500 font-semibold' : 'text-gray-400'">
                            <span x-text="texto.length"></span> / <span x-text="limite"></span>
                        </p>
                    </div>
                    <div x-data="{ texto: '{{ old('surgical_history', $patient->surgical_history) }}', limite: 300 }">
                        <x-wire-textarea label="Antecedentes quirúrgicos" name="surgical_history" x-model="texto" maxlength="300">{{ old('surgical_history', $patient->surgical_history) }}</x-wire-textarea>
                        <p class="text-sm mt-1 text-right" :class="texto.length >= limite ? 'text-red-500 font-semibold' : 'text-gray-400'">
                            <span x-text="texto.length"></span> / <span x-text="limite"></span>
                        </p>
                    </div>
                </div>
            </x-tabs-content>

            {{-- Tab 3 --}}
            <x-tabs-content tab="informacion-general">
                <div class="grid lg:grid-cols-2 gap-4">
                    <x-wire-native-select label="Tipo de sangre" class="mb-4" name="bloodtype_id">
                        <option value="">Seleccione un tipo de sangre</option>
                        @foreach ($blood_types as $blood_type)
                            <option value="{{ $blood_type->id }}" @selected(old('bloodtype_id') == $blood_type->id or $patient->bloodtype_id == $blood_type->id)>
                                {{ $blood_type->name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                    <x-wire-input label="Peso (kg)" name="weight" placeholder="Peso del paciente" value="{{ old('weight', $patient->weight) }}"/>
                    <x-wire-input label="Altura (cm)" name="height" placeholder="Altura del paciente" value="{{ old('height', $patient->height) }}"/>
                    <x-wire-input label="Observaciones" name="observations" placeholder="Observaciones del paciente" value="{{ old('observations', $patient->observations) }}"/>
                </div>
            </x-tabs-content>

            {{-- Tab 4 --}}
            <x-tabs-content tab="contacto-emergencia">
                <div class="grid lg:grid-cols-2 gap-4">
                    <x-wire-input label="Nombre del contacto" name="emergency_contact_name" placeholder="Nombre del contacto de emergencia" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"/>
                    <x-wire-input label="Teléfono del contacto" name="emergency_contact_phone" placeholder="Teléfono del contacto de emergencia" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"/>
                    <x-wire-input label="Relación con el paciente" name="emergency_contact_relationship" placeholder="Relación con el paciente" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"/>
                </div>
            </x-tabs-content>

        </x-tabs>
    </x-wire-card>
</form>
</x-admin-layout>