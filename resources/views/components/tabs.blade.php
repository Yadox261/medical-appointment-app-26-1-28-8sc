@props(['active' => 'datos-personales', 'errorsAntecedentes' => false, 'errorsInfoGeneral' => false, 'errorsContacto' => false])

<div x-data="{
    tab: '{{ $active }}',
    errorsAntecedentes: {{ $errorsAntecedentes ? 'true' : 'false' }},
    errorsInfoGeneral: {{ $errorsInfoGeneral ? 'true' : 'false' }},
    errorsContacto: {{ $errorsContacto ? 'true' : 'false' }}
}" class="w-full">
    @isset($header)
        <div class="border-b border-gray-200 dark:border-gray-700 bg-default">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                {{ $header }}
            </ul>
        </div>
    @endisset
    <div class="p-4 mt-4">
        {{ $slot }}
    </div>
</div>