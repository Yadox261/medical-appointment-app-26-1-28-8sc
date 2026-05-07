<div class="flex items-center gap-2">
    {{-- Editar doctor --}}
    <a href="{{ route('admin.doctors.edit', $doctor) }}">
        <x-wire-button blue xs title="Editar doctor">
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    </a>

    {{-- Gestionar horarios --}}
    <a href="{{ route('admin.doctors.schedule', $doctor) }}">
        <x-wire-button positive xs title="Gestionar horarios">
            <i class="fa-solid fa-clock"></i>
        </x-wire-button>
    </a>
</div>
