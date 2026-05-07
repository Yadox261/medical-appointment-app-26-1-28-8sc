<div x-data="scheduleManager" class="space-y-4 mt-4">

    {{-- ===== GESTOR DE HORARIOS ===== --}}
    <x-wire-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-700">
                Gestor de horarios
            </h3>
            <button x-on:click="save()"
                class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700
                       text-white rounded-lg text-sm font-semibold transition shadow-sm">
                Guardar horario
            </button>
        </div>

        {{-- Tabla scrollable horizontalmente --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-sm text-left">

                {{-- Encabezado --}}
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th
                            class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-32 sticky left-0 bg-gray-50 z-10">
                            DÍA/HORA
                        </th>
                        @foreach ($days as $dayNum => $dayName)
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase min-w-[140px]">
                                {{ $dayName }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @php
                        $hours = collect($timeSlots)->groupBy(fn($t) => substr($t, 0, 2));
                    @endphp

                    @foreach ($hours as $hour => $slots)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 align-top sticky left-0 z-10 bg-inherit border-r border-gray-100">
                                <label class="inline-flex items-center gap-2 cursor-pointer mt-1">
                                    <input type="checkbox" :checked="isAllInHourSelected('{{ $hour }}')"
                                        x-on:change="toggleAllInHour('{{ $hour }}')"
                                        class="w-4 h-4 rounded text-blue-600 border-gray-300 cursor-pointer">
                                    <span class="font-semibold text-gray-700">{{ $hour }}:00:00</span>
                                </label>
                            </td>

                            @foreach ($days as $dayNum => $dayName)
                                <td class="px-4 py-4 align-top">
                                    <div class="flex flex-col gap-2">
                                        <label class="inline-flex items-center gap-2 cursor-pointer mb-1">
                                            <input type="checkbox"
                                                :checked="isAllInHourDaySelected({{ $dayNum }}, '{{ $hour }}')"
                                                x-on:change="toggleAllInHourDay({{ $dayNum }}, '{{ $hour }}')"
                                                class="w-4 h-4 rounded text-blue-600 border-gray-300 cursor-pointer">
                                            <span class="text-xs text-gray-500 font-medium">Todos</span>
                                        </label>

                                        @foreach ($slots as $time)
                                            @php
                                                $endTime = date('H:i', strtotime($time . ' +15 minutes'));
                                            @endphp
                                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox"
                                                    :checked="isSelected({{ $dayNum }}, '{{ $time }}')"
                                                    x-on:change="toggle({{ $dayNum }}, '{{ $time }}')"
                                                    class="w-4 h-4 rounded text-blue-600 border-gray-300 cursor-pointer focus:ring-blue-500">
                                                <span class="text-xs text-gray-600">{{ $time }} -
                                                    {{ $endTime }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </x-wire-card>

    @script
    <script>
        Alpine.data('scheduleManager', () => ({
            schedule: {},

            init() {
                const daysKeys = Object.keys($wire.days);
                daysKeys.forEach(day => {
                    $wire.timeSlots.forEach(time => {
                        this.schedule[`${day}|${time}`] = false;
                    });
                });
                $wire.selectedSlots.forEach(slot => {
                    this.schedule[slot] = true;
                });
            },

            getSlotsInHour(hour) {
                return $wire.timeSlots.filter(t => t.startsWith(hour));
            },

            isSelected(day, time) {
                return !!this.schedule[`${day}|${time}`];
            },

            toggle(day, time) {
                const key = `${day}|${time}`;
                this.schedule[key] = !this.schedule[key];
            },

            isAllInHourDaySelected(day, hour) {
                const slots = this.getSlotsInHour(hour);
                return slots.length > 0 && slots.every(time => this.isSelected(day, time));
            },

            toggleAllInHourDay(day, hour) {
                const allSelected = this.isAllInHourDaySelected(day, hour);
                this.getSlotsInHour(hour).forEach(time => {
                    this.schedule[`${day}|${time}`] = !allSelected;
                });
            },

            isAllInHourSelected(hour) {
                const slots = this.getSlotsInHour(hour);
                const dayKeys = Object.keys($wire.days);
                return dayKeys.every(day => slots.every(time => this.isSelected(day, time)));
            },

            toggleAllInHour(hour) {
                const allSelected = this.isAllInHourSelected(hour);
                const dayKeys = Object.keys($wire.days);
                dayKeys.forEach(day => {
                    this.getSlotsInHour(hour).forEach(time => {
                        this.schedule[`${day}|${time}`] = !allSelected;
                    });
                });
            },

            save() {
                const selected = Object.keys(this.schedule).filter(k => this.schedule[k]);
                $wire.saveSchedule(selected);
            }
        }));
    </script>
    @endscript
</div>
