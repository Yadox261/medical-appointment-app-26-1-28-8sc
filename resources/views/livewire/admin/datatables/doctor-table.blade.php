<div>
    {{-- Buscador --}}
    <div class="mb-4">
        <input wire:model.live="search" type="text"
               placeholder="Buscar doctor..."
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
                        Correo {{ $sortBy === 'users.email' ? ($sortDir === 'asc' ? '↑' : '↓') : '' }}
                    </th>
                    <th class="px-6 py-3 cursor-pointer" wire:click="sort('doctors.specialty')">
                        Especialidad {{ $sortBy === 'doctors.specialty' ? ($sortDir === 'asc' ? '↑' : '↓') : '' }}
                    </th>
                    <th class="px-6 py-3">Cédula Profesional</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($doctors as $doctor)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            <div class="flex items-center gap-3">
                                <img src="{{ $doctor->user->profile_photo_url }}"
                                     class="w-8 h-8 rounded-full object-cover"
                                     alt="{{ $doctor->user->name }}">
                                {{ $doctor->user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $doctor->user->email }}</td>
                        <td class="px-6 py-4">
                            @if($doctor->specialty)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    {{ $doctor->specialty }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $doctor->cedula_profesional ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                @include('admin.doctors.actions', ['doctor' => $doctor])
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                            No se encontraron doctores.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $doctors->links() }}
    </div>
</div>
