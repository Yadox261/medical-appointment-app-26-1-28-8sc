<div class="flex items-center gap-2">
    {{-- Editar cita --}}
    <a href="{{ route('admin.appointments.edit', $appointment) }}">
        <x-wire-button blue xs title="Editar cita">
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    </a>

    {{-- Atender consulta --}}
    <a href="{{ route('admin.appointments.consultation', $appointment) }}">
        <x-wire-button positive xs title="Atender consulta">
            <i class="fa-solid fa-stethoscope"></i>
        </x-wire-button>
    </a>

    {{-- Eliminar cita --}}
    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST"
          onsubmit="return confirm('¿Estás seguro de eliminar esta cita?')">
        @csrf
        @method('DELETE')
        <x-wire-button red xs type="submit" title="Eliminar cita">
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>
