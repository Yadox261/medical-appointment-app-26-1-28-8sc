@php
   $Links = [ 
     [
       'icon' => 'fa-solid fa-gauge',
       'name' => 'Dashboard',
       'href' => route('admin.dashboard'), 
       'active' => request()->routeIs('admin.dashboard')
     ],
     [
       'header' => 'Gestión',
     ],
     [
       'name' => 'Usuarios',
       'icon' => 'fa-solid fa-users',
       'href' => route('admin.users.index'), 
       'active' => request()->routeIs('admin.users.*'),
     ],
     [
       'name' => 'Roles y Permisos',
       'icon' => 'fa-solid fa-shield-halved',
       'href' => route('admin.roles.index'), 
       'active' => request()->routeIs('admin.roles.*'),
     ]
   ];
@endphp

<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-5 py-2 overflow-y-auto bg-neutral-primary-soft border-e border-default">
      <a href="/" class="flex items-center ps-2.5 mb-5">
         <img src="{{ asset('images/Dokka.jpg') }}" class="h-12 me-3" alt="Healthify Logo" />
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">Rainbow Force</span>
      </a>
      <ul class="space-y-2 font-medium">
         @foreach ($Links as $link) 
         <li>
            @isset($link['header'])
               {{-- Encabezado de sección --}}
               <div class="px-2 py-2 text-xs text-gray-500 uppercase font-semibold">
                  {{ $link['header'] }}
               </div>
            @elseif(isset($link['submenu']))
               {{-- Enlace con submenú desplegable --}}
               <button type="button" 
                  class="flex items-center w-full justify-between px-2 py-1.5 text-gray-700 rounded-lg hover:bg-purple-100 hover:text-purple-700 group {{ $link['active'] ? 'bg-purple-100 text-purple-700 font-semibold' : '' }}" 
                  data-collapse-toggle="dropdown-{{ $loop->index }}">
                  <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                     <i class="{{ $link['icon'] }}"></i>
                  </span>
                  <span class="flex-1 ms-3 text-left whitespace-nowrap">{{ $link['name'] }}</span>
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                  </svg>
               </button>
               <ul id="dropdown-{{ $loop->index }}" class="hidden py-2 space-y-2">
                  @foreach ($link['submenu'] as $item)
                     <li>
                        <a href="{{ $item['href'] }}" 
                           class="pl-10 flex items-center px-2 py-1.5 text-gray-700 rounded-lg hover:bg-purple-100 hover:text-purple-700 group {{ $item['active'] ? 'bg-purple-100 text-purple-700 font-semibold' : '' }}">
                           {{ $item['name'] }}
                        </a>
                     </li>
                  @endforeach
               </ul>
            @else
               {{-- Enlace simple --}}
               <a href="{{ $link['href'] }}" 
                  class="flex items-center px-2 py-1.5 text-gray-700 rounded-lg hover:bg-purple-100 hover:text-purple-700 group {{ $link['active'] ? 'bg-purple-100 text-purple-700 font-semibold' : '' }}">
                  <span class="w-6 h-6 flex items-center justify-center text-gray-500">
                     <i class="{{ $link['icon'] }}"></i>
                  </span>
                  <span class="ms-3">{{ $link['name'] }}</span>
               </a>
            @endif
         </li>
         @endforeach 
      </ul>
   </div>
</aside>