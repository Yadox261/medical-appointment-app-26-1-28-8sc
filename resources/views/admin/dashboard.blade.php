<x-admin-layout :breadcrumb="[
    [
        'name' => 'Dashboard',
        'href' => route('dashboard')
    ],
    [
        'name' => 'Ejemplo',
        'href' => route('dashboard')
    ]
]">
    <img src="{{ asset('images/dokkaebi-r6.gif') }}" alt="mi gif" style="width: 1500px; height: 700px;">
</x-admin-layout>