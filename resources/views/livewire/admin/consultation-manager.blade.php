<div class="mt-4 space-y-6">

    {{-- ===== HEADER DEL PACIENTE ===== --}}
    <x-wire-card>
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="shrink-0 flex items-center justify-center w-14 h-14 bg-gray-100 text-gray-500 rounded-full text-xl font-bold border border-gray-200">
                    {{ strtoupper(substr($appointment->patient->user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $appointment->patient->user->name }}
                    </h2>
                    <p class="text-gray-500 text-sm">
                        DNI: {{ $appointment->patient->user->id_number ?? 'No registrado' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-3 shrink-0">
                <a href="{{ route('admin.patients.edit', $appointment->patient) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg text-sm font-medium transition shadow-sm">
                    <i class="fa-solid fa-file-medical text-gray-400"></i> Ver Historia
                </a>
                <button wire:click="openPastConsultations"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg text-sm font-medium transition shadow-sm">
                    <i class="fa-solid fa-clock-rotate-left text-gray-400"></i> Consultas Anteriores
                </button>
            </div>
        </div>
    </x-wire-card>

    {{-- ===== TABS & CONTENT ===== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        
        {{-- Cabecera de tabs (Flowbite Style) --}}
        <div class="border-b border-gray-200 px-4 pt-2">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                <li class="mr-2">
                    <button wire:click="setTab('consulta')"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition
                                   {{ $activeTab === 'consulta' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        <i class="fa-solid fa-notes-medical mr-2 {{ $activeTab === 'consulta' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Consulta
                    </button>
                </li>
                <li class="mr-2">
                    <button wire:click="setTab('receta')"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition
                                   {{ $activeTab === 'receta' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        <i class="fa-solid fa-prescription-bottle-medical mr-2 {{ $activeTab === 'receta' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Receta
                    </button>
                </li>
            </ul>
        </div>

        <div class="p-6">
            {{-- ===== TAB CONSULTA ===== --}}
            @if($activeTab === 'consulta')
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Diagnóstico</label>
                        <textarea wire:model.defer="diagnosis" rows="4"
                                  placeholder="Describa el diagnóstico del paciente aquí..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Tratamiento</label>
                        <textarea wire:model.defer="treatment" rows="4"
                                  placeholder="Describa el tratamiento recomendado aquí..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Notas</label>
                        <textarea wire:model.defer="notes" rows="3"
                                  placeholder="Agregue notas adicionales sobre la consulta..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition resize-none"></textarea>
                    </div>
                </div>
            @endif

            {{-- ===== TAB RECETA ===== --}}
            @if($activeTab === 'receta')
                <div class="space-y-4">
                    <div class="grid grid-cols-12 gap-4 text-xs font-semibold text-gray-500 mb-1">
                        <div class="col-span-5">Medicamento</div>
                        <div class="col-span-3">Dosis</div>
                        <div class="col-span-3">Frecuencia / Duración</div>
                        <div class="col-span-1"></div>
                    </div>

                    @foreach ($medications as $index => $med)
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-5">
                                <input type="text" wire:model.defer="medications.{{ $index }}.medication"
                                       placeholder="Ej: Amoxicilina 500mg"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                            <div class="col-span-3">
                                <input type="text" wire:model.defer="medications.{{ $index }}.dose"
                                       placeholder="Ej: 1 cada 8 horas"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                            <div class="col-span-3">
                                <input type="text" wire:model.defer="medications.{{ $index }}.frequency"
                                       placeholder="Ej: cada 8 horas por 7 días"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                            </div>
                            <div class="col-span-1 flex justify-center">
                                <button wire:click="removeMedication({{ $index }})" type="button"
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <button wire:click="addMedication" type="button"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition shadow-sm">
                            <i class="fa-solid fa-plus text-gray-400"></i> Añadir Medicamento
                        </button>
                    </div>
                </div>
            @endif

            <div class="flex justify-end mt-8">
                <button wire:click="saveConsultation" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-semibold transition shadow-sm disabled:opacity-60">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Consulta
                </button>
            </div>
        </div>
    </div>
</div>



{{-- ===== MODAL: CONSULTAS ANTERIORES ===== --}}
@if($showPastConsultations)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" wire:click.self="closePastConsultations">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl mx-4 max-h-[85vh] flex flex-col relative">
            
            <div class="flex items-center justify-between p-6 border-b border-gray-100 shrink-0">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Consultas Anteriores</h3>
                <button wire:click="closePastConsultations" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-4 flex-1">
                @forelse ($pastConsultations as $past)
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="flex justify-between items-center bg-gray-50 px-5 py-3 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-calendar-day text-blue-500"></i>
                                <span class="font-bold text-gray-800 text-sm">
                                    {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($past->start_time)->format('H:i') }}
                                </span>
                            </div>
                            <button type="button" class="px-3 py-1.5 border border-indigo-200 text-indigo-600 hover:bg-indigo-50 rounded-lg text-xs font-semibold transition cursor-not-allowed opacity-70">
                                Consultar Detalle
                            </button>
                        </div>
                        <div class="p-5 space-y-3 bg-white">
                            <p class="text-xs text-gray-500">Atendido por: <span class="font-medium text-gray-800">Dr. {{ $past->doctor->user->name }}</span></p>
                            
                            <div class="text-sm text-gray-700 space-y-1 mt-3">
                                <p><span class="font-semibold text-gray-800">Diagnóstico:</span> {{ $past->consultation->diagnosis ?? '—' }}</p>
                                <p><span class="font-semibold text-gray-800">Tratamiento:</span> {{ $past->consultation->treatment ?? '—' }}</p>
                                @if($past->consultation->notes)
                                    <p><span class="font-semibold text-gray-800">Notas:</span> {{ $past->consultation->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400">
                        <i class="fa-solid fa-folder-open text-4xl mb-3 block text-gray-300"></i>
                        No hay consultas anteriores registradas para este paciente.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endif
