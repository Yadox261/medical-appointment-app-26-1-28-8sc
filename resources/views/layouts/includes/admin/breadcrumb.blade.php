{{-- verificar  si hay un elemento en el arreglo--}}
@if (is_array($breadcrumb) && count($breadcrumb))
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumb as $item)
                <li class="flex items-center">
                    @unless ($loop->first)
                        <span class="px-2 text-purple-400">
                            >
                        </span>
                    @endunless
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="flex items-center opacity-60 hover:opacity-100 transition">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{ $item['name'] }}
                    @endisset
                </li>
            @endforeach
        </ol>
    </nav>
@endif