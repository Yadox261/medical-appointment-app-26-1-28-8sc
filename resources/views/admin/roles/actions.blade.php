<div class="flex items-center gap-2">
    <a href="{{ route('admin.roles.edit', $role) }}">
        <x-wire-button blue xs>
            <i class="fa-solid fa-pen-to-square"></i>
        </x-wire-button>
    </a>

    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>