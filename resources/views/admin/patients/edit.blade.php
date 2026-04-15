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
 <form action="{{route('admin.patients.update', $patient)}}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <x-wire-card>
    <div class="flex items-center justify-between w-full">
        
        {{-- GRUPO 1: Foto y Datos (Lado izquierdo) --}}
        <div class="flex items-center">
            <img src="{{$patient->user->profile_photo_url}}" alt="{{$patient->user->name}}" class="w-20 h-20 rounded-full mr-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 leading-tight">{{$patient->user->name}}</h2>
                <p class="text-gray-600">{{$patient->user->email}}</p>
            </div>
        </div>

        {{-- GRUPO 2: Botones (Lado derecho) --}}
        {{-- Usamos 'shrink-0' para que los botones no se compriman si el nombre es largo --}}
        <div class="flex gap-3 mt-6 mt-0 ml-6 shrink-0">
            
                <x-wire-button outline gray href="{{route('admin.patients.index')}}">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </x-wire-button>
            
            <x-wire-button blue type="submit"> 
                <i class="fa-solid fa-check mr-2"></i> Guardar
            </x-wire-button>
        </div>

    </div>
</x-wire-card>
{{--tabs de navegacion --}}

<x-wire-card x-data="{tab: 'datos-personales'}">
    {{-- menu de tabs --}}
    <div class="border-b border-gray-200 dark:border-gray-700 bg-default">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">

            {{-- Tab 1 DATOS PERSONALES --}}
            <li class="me-2">
                <a href="#" x-on:click="tab = 'datos-personales'"
                    :class="tab === 'datos-personales' 
                        ? 'text-blue-600 border-blue-600 bg-blue-25 dark:bg-blue-900/20' 
                        : 'border-transparent hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                    class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-base transition-all duration-300 ease-in-out group hover:scale-105"
                    :aria-current="tab === 'datos-personales' ? 'page' : undefined">
                    <svg class="w-4 h-4 me-2 transition-colors duration-300 group-hover:text-blue-500"
                        :class="tab === 'datos-personales' ? 'text-blue-600' : 'text-gray-400'"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    Datos Personales
                </a>
            </li>

            {{-- Tab 2 Antecedentes Medicos --}}
            <li class="me-2">
                <a href="#" x-on:click="tab = 'antecedentes-medicos'"
                    :class="tab === 'antecedentes-medicos' 
                        ? 'text-blue-600 border-blue-600 bg-blue-25 dark:bg-blue-900/20' 
                        : 'border-transparent hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                    class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-base transition-all duration-300 ease-in-out group hover:scale-105"
                    :aria-current="tab === 'antecedentes-medicos' ? 'page' : undefined">
                    <svg class="w-5 h-5 me-2 transition-colors duration-300 group-hover:text-blue-500"
                        :class="tab === 'antecedentes-medicos' ? 'text-blue-600' : 'text-gray-400'"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                    </svg>
                    Antecedentes
                </a>
            </li>

            {{-- Tab 3 Informacion General --}}
            <li class="me-2">
                <a href="#" x-on:click="tab = 'informacion-general'"
                    :class="tab === 'informacion-general' 
                        ? 'text-blue-600 border-blue-600 bg-blue-25 dark:bg-blue-900/20' 
                        : 'border-transparent hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                    class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-base transition-all duration-300 ease-in-out group hover:scale-105"
                    :aria-current="tab === 'informacion-general' ? 'page' : undefined">
                    <svg class="w-5 h-5 me-2 transition-colors duration-300 group-hover:text-blue-500"
                        :class="tab === 'informacion-general' ? 'text-blue-600' : 'text-gray-400'"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                    </svg>
                    Informacion General
                </a>
            </li>

            {{-- Tab 4 Contacto de Emergencia --}}
            <li class="me-2">
                <a href="#" x-on:click="tab = 'contacto-emergencia'"
                    :class="tab === 'contacto-emergencia' 
                        ? 'text-blue-600 border-blue-600 bg-blue-25 dark:bg-blue-900/20' 
                        : 'border-transparent hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                    class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-base transition-all duration-300 ease-in-out group hover:scale-105"
                    :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
                    <svg class="w-5 h-5 me-2 transition-colors duration-300 group-hover:text-blue-500"
                        :class="tab === 'contacto-emergencia' ? 'text-blue-600' : 'text-gray-400'"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z"/>
                        <path d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z"/>
                    </svg>
                    Contacto de Emergencia
                </a>
            </li>
        </ul>
    </div>
    {{-- contenido de tabs --}}
    <div class="p-4 mt-4")>
        {{-- contenido de tab 1 --}}
        <div x-show="tab === 'datos-personales'">
        <x-wire-alert shadow="none" padding="none">
        <x-slot name="slot">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    
                    {{-- Lado Izquierdo: Icono y Textos --}}
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <svg class="w-16 h-16 text-blue-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
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

                    {{-- Lado Derecho: Botón de Acción --}}
                    <div class="flex-shrink-0 ml-auto">
                        <x-wire-button blue sm icon="pencil" :href="route('admin.users.edit', $patient->user)" label="Editar Usuario" target="_blank"/>
                    </div>

                </div>
            </div>
    </x-slot>
</x-wire-alert>
        </div>
        <div x-show="tab === 'antecedentes-medicos'">
            
        </div>
        <div x-show="tab === 'informacion-general'">
            
        </div>
        <div x-show="tab === 'contacto-emergencia'">
           
        </div>
    </div>
</x-wire-card>
</form>
</x-admin-layout>