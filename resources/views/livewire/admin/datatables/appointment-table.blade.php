<div>
    {{-- Buscador --}}
    <div class="mb-4">
        <input wire:model.live="search" type="text"
               placeholder="Buscar por paciente o doctor..."
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
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3 cursor-pointer" wire:click="sort('date')">
                        Fecha {{ $sortBy === 'date' ? ($sortDir === 'asc' ? '↑' : '↓') : '' }}
                    </th>
                    <th class="px-6 py-3">Paciente</th>
                    <th class="px-6 py-3">Doctor</th>
                    <th class="px-6 py-3">Hora inicio</th>
                    <th class="px-6 py-3">Hora fin</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-400">{{ $appointment->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">{{ $appointment->patient->user->name ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $appointment->doctor->user->name ?? '—' }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $colors = [1 => 'blue', 2 => 'green', 3 => 'red'];
                                $labels = [1 => 'Programado', 2 => 'Completado', 3 => 'Cancelado'];
                                $color  = $colors[$appointment->status] ?? 'gray';
                                $label  = $labels[$appointment->status] ?? 'Desconocido';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $color === 'blue'  ? 'bg-blue-100 text-blue-700'   : '' }}
                                {{ $color === 'green' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $color === 'red'   ? 'bg-red-100 text-red-700'     : '' }}
                                {{ $color === 'gray'  ? 'bg-gray-100 text-gray-700'   : '' }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                @include('admin.appointments.actions', ['appointment' => $appointment])
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                            No se encontraron citas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
</div>
