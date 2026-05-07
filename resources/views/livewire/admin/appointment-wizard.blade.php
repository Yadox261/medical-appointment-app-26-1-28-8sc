<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- Lado Izquierdo: Buscador y Resultados --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Card: Buscar disponibilidad --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Buscar disponibilidad</h3>
            <p class="text-sm text-gray-500 mb-6">Encuentra el horario perfecto para tu cita.</p>

            <form wire:submit.prevent="searchAvailability" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                {{-- Fecha --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Fecha</label>
                    <input type="date" wire:model.defer="searchDate" min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Hora --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Hora</label>
                    <select wire:model.defer="searchTimeRange"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach ($timeRanges as $range)
                            <option value="{{ $range }}">{{ $range }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Especialidad --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Especialidad (Opcional)</label>
                    <select wire:model.defer="searchSpecialty"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cualquiera</option>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón Buscar --}}
                <div class="md:col-span-3 flex justify-end mt-2">
                    <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
                        Buscar disponibilidad
                    </button>
                </div>
            </form>
        </div>

        {{-- Resultados de disponibilidad --}}
        @if(count($availableDoctors) > 0)
            <div class="space-y-4">
                @foreach ($availableDoctors as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row gap-6">
                        {{-- Avatar --}}
                        <div class="shrink-0 flex items-center justify-center w-14 h-14 bg-blue-50 text-blue-600 rounded-full text-xl font-bold border border-blue-100">
                            {{ strtoupper(substr($item['doctor']->user->name, 0, 2)) }}
                        </div>
                        
                        {{-- Doctor Info --}}
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-800">Dr. {{ $item['doctor']->user->name }}</h4>
                            <p class="text-sm text-blue-500 font-medium mb-4">{{ $item['doctor']->specialty ?? 'General' }}</p>

                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Horarios disponibles:</p>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($item['slots'] as $slot)
                                        @php
                                            $isSlotSelected = $selectedDoctorId == $item['doctor']->id && $selectedTimeSlot == $slot;
                                        @endphp
                                        <button type="button"
                                                wire:click="selectSlot({{ $item['doctor']->id }}, '{{ $slot }}')"
                                                class="px-4 py-2 text-sm font-semibold rounded-lg transition border 
                                                {{ $isSlotSelected ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-blue-50 text-blue-600 border-blue-100 hover:bg-blue-100' }}">
                                            {{ \Carbon\Carbon::parse($slot)->format('H:i:s') }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(request()->method() == 'POST')
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-500">
                <i class="fa-solid fa-user-doctor text-4xl mb-4 text-gray-300"></i>
                <p>No se encontraron horarios disponibles para la búsqueda.</p>
            </div>
        @endif

    </div>

    {{-- Lado Derecho: Resumen de la Cita --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Resumen de la cita</h3>
            
            <div class="space-y-4 text-sm mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Doctor:</span>
                    <span class="font-semibold text-gray-800 text-right">
                        @if($selectedDoctorId)
                            @php
                                $d = \App\Models\Doctor::with('user')->find($selectedDoctorId);
                            @endphp
                            Dr. {{ $d->user->name ?? '—' }}
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Fecha:</span>
                    <span class="font-semibold text-gray-800">{{ $searchDate ? \Carbon\Carbon::parse($searchDate)->format('Y-m-d') : '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Horario:</span>
                    <span class="font-semibold text-gray-800">
                        @if($selectedTimeSlot)
                            {{ \Carbon\Carbon::parse($selectedTimeSlot)->format('H:i:s') }} - {{ \Carbon\Carbon::parse($selectedTimeSlot)->addMinutes(15)->format('H:i:s') }}
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-medium">Duración:</span>
                    <span class="font-semibold text-gray-800">15 minutos</span>
                </div>
            </div>

            <hr class="mb-6 border-gray-100">

            <div class="space-y-5">
                {{-- Seleccionar Paciente --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-2">Paciente <span class="text-red-500">*</span></label>
                    <select wire:model.defer="patientId"
                            class="w-full px-4 py-2.5 bg-gray-50 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition
                                   @error('patientId') border-red-500 @else border-gray-200 @enderror">
                        <option value="">— Seleccione un paciente —</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                        @endforeach
                    </select>
                    @error('patientId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Motivo --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-2">Motivo de la cita</label>
                    <textarea wire:model.defer="reason" rows="4"
                              placeholder="Chequeo de medicamentos, revisión general..."
                              class="w-full px-4 py-3 bg-gray-50 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition resize-none
                                     @error('reason') border-red-500 @else border-gray-200 @enderror"></textarea>
                    @error('reason') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="button" wire:click="confirmAppointment"
                    @if(!$selectedDoctorId || !$selectedTimeSlot) disabled @endif
                    class="mt-6 w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition shadow-sm
                           disabled:bg-blue-300 disabled:cursor-not-allowed">
                Confirmar cita
            </button>

            @error('selectedDoctorId') 
                <p class="text-xs text-center text-red-500 mt-3 font-medium">Debe seleccionar un horario disponible.</p> 
            @enderror

        </div>
    </div>

</div>
