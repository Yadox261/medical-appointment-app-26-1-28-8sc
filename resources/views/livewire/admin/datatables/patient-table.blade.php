<div>
    {{-- Buscador --}}
    <div class="mb-4">
        <input wire:model.live="search" type="text"
               placeholder="Buscar paciente..."
               class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
    </div>

    {{-- Mensaje flash --}}
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white rounded-2xl shadow">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-xs uppercase text-gray-400 border-b">
                <tr>
                    <th class="px-6 py-3 cursor-pointer" wire:click="sort('users.name')">
                        Nombre {{ $sortBy === 'users.name' ? ($sortDir === 'asc' ? '↑' : '↓') : '' }}
                    </th>
                    <th class="px-6 py-3 cursor-pointer" wire:click="sort('users.email')">
                        Email {{ $sortBy === 'users.email' ? ($sortDir === 'asc' ? '↑' : '↓') : '' }}
                    </th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3">Tipo de sangre</th>
                    <th class="px-6 py-3">Alergias</th>
                    <th class="px-6 py-3">Enf. crónicas</th>
                    <th class="px-6 py-3">Cirugías previas</th>
                    <th class="px-6 py-3">Antec. familiares</th>
                    <th class="px-6 py-3">Observaciones</th>
                    <th class="px-6 py-3">Contacto emergencia</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($patients as $patient)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $patient->name }}</td>
                        <td class="px-6 py-4">{{ $patient->email }}</td>
                        <td class="px-6 py-4">{{ $patient->phone ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($patient->bloodType)
                                <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">
                                    🩸 {{ $patient->bloodType->name }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $patient->allergies ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $patient->chronical_conditions ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $patient->surgical_history ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $patient->family_history ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $patient->observations ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($patient->emergency_contact_name)
                                <div class="text-xs">
                                    <p class="font-semibold">{{ $patient->emergency_contact_name }}</p>
                                    <p class="text-gray-400">{{ $patient->emergency_contact_phone ?? '—' }}</p>
                                    <p class="text-gray-400 italic">{{ $patient->emergency_contact_relationship ?? '—' }}</p>
                                </div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.patients.show', $patient) }}"
                                   class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition">
                                    Ver
                                </a>
                                <a href="{{ route('admin.patients.edit', $patient) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs hover:bg-yellow-600 transition">
                                    Editar
                                </a>
                                <button wire:click="delete({{ $patient->id }})"
                                        wire:confirm="¿Estás seguro de eliminar este paciente?"
                                        class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-8 text-center text-gray-400">
                            No se encontraron pacientes.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>