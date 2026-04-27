@props([
    'tab'       => '',
    'hasErrors' => false,
])

<li class="me-2">
    <a href="#" x-on:click.prevent="tab = '{{ $tab }}'"
        :class="{
            'text-red-600 border-red-600 bg-red-50 dark:bg-red-900/20': {{ $hasErrors ? 'true' : 'false' }},
            'text-blue-600 border-blue-600 bg-blue-50 dark:bg-blue-900/20': tab === '{{ $tab }}' && !{{ $hasErrors ? 'true' : 'false' }},
            'border-transparent hover:text-blue-600 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20': tab !== '{{ $tab }}' && !{{ $hasErrors ? 'true' : 'false' }}
        }"
        class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-base transition-all duration-300 ease-in-out group hover:scale-105"
        :aria-current="tab === '{{ $tab }}' ? 'page' : undefined">

        {{-- Ícono --}}
        <span :class="{
            'text-red-500': {{ $hasErrors ? 'true' : 'false' }},
            'text-blue-600': tab === '{{ $tab }}' && !{{ $hasErrors ? 'true' : 'false' }},
            'text-gray-400': tab !== '{{ $tab }}' && !{{ $hasErrors ? 'true' : 'false' }}
        }" class="w-5 h-5 me-2 transition-colors duration-300">
            {{ $icon }}
        </span>

        {{-- Label --}}
        {{ $slot }}

        {{-- Ícono de exclamación si hay errores --}}
        @if($hasErrors)
            <svg class="w-4 h-4 ms-1 text-red-500 animate-bounce"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" clip-rule="evenodd"/>
            </svg>
        @endif
    </a>
</li>