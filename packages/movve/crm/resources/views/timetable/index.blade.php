<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text">
                {{ __('crm::timetable.title') }}
            </h2>
            <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('crm::timetable.add_booking') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="timetableView()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 lg:p-8">
                    <!-- Toolbar -->
                    <div class="flex items-center mb-6 gap-2">
                        <button @click="view = 'day'" :class="view === 'day' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded font-semibold text-sm transition">{{ __('crm::timetable.day') }}</button>
                        <button @click="view = 'week'" :class="view === 'week' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded font-semibold text-sm transition">{{ __('crm::timetable.week') }}</button>
                        <button @click="view = 'month'" :class="view === 'month' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded font-semibold text-sm transition">{{ __('crm::timetable.month') }}</button>
                        <button @click="view = 'year'" :class="view === 'year' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded font-semibold text-sm transition">{{ __('crm::timetable.year') }}</button>
                    </div>
                    <!-- Week View -->
                    <div x-show="view === 'week'" class="overflow-x-auto">
                        <div class="flex items-center mb-6">
                            <button class="px-3 py-1 bg-gray-200 rounded mr-2" @click="prevWeek">&#8592;</button>
                            <span class="font-semibold text-lg mx-2" x-text="weekLabel"></span>
                            <button class="px-3 py-1 bg-gray-200 rounded ml-2" @click="nextWeek">&#8594;</button>
                        </div>
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="w-16"></th>
                                    <template x-for="day in weekDays" :key="day">
                                        <th class="px-4 py-2 text-center text-xs font-bold text-gray-600" x-text="day"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="row in weekRows" :key="row.key">
                                    <tr>
                                        <td class="border-t border-gray-100 align-top text-xs text-gray-400 px-2 py-0.5 w-16 text-right" x-text="row.time"></td>
                                        <template x-for="d in 7" :key="d">
                                            <td class="border-t border-gray-100 align-top px-2 py-1 cursor-pointer min-w-[90px] h-8 relative group transition-colors duration-100 hover:z-10 hover:shadow-lg hover:bg-indigo-100/60">
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                    <button class="text-xs px-2 py-1 rounded-full bg-indigo-600 text-white shadow hover:bg-indigo-700 flex items-center pointer-events-auto" title="{{ __('crm::timetable.add_booking') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Day View -->
                    <div x-show="view === 'day'" class="overflow-x-auto">
                        <div class="flex items-center mb-6">
                            <button class="px-3 py-1 bg-gray-200 rounded mr-2" @click="prevDay">&#8592;</button>
                            <span class="font-semibold text-lg mx-2" x-text="dayLabel"></span>
                            <button class="px-3 py-1 bg-gray-200 rounded ml-2" @click="nextDay">&#8594;</button>
                        </div>
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="w-16"></th>
                                    <th class="px-4 py-2 text-center text-xs font-bold text-gray-600" x-text="dayLabel"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="row in dayRows" :key="row.key">
                                    <tr>
                                        <td class="border-t border-gray-100 align-top text-xs text-gray-400 px-2 py-0.5 w-16 text-right" x-text="row.time"></td>
                                        <td class="border-t border-gray-100 align-top px-2 py-1 cursor-pointer min-w-[90px] h-8 relative group transition-colors duration-100 hover:z-10 hover:shadow-lg hover:bg-indigo-100/60">
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                <button class="text-xs px-2 py-1 rounded-full bg-indigo-600 text-white shadow hover:bg-indigo-700 flex items-center pointer-events-auto" title="{{ __('crm::timetable.add_booking') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Month View (klikbaar naar dag, met weeknummers links) -->
                    <div x-show="view === 'month'" class="overflow-x-auto">
                        <div class="flex items-center mb-6">
                            <button class="px-3 py-1 bg-gray-200 rounded mr-2" @click="prevMonth">&#8592;</button>
                            <span class="font-semibold text-lg mx-2" x-text="monthLabel"></span>
                            <button class="px-3 py-1 bg-gray-200 rounded ml-2" @click="nextMonth">&#8594;</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="w-10 text-xs text-gray-400 font-bold text-center">Wk</th>
                                        <template x-for="d in 7" :key="d">
                                            <th class="px-2 py-1 text-center text-xs font-bold text-gray-600" x-text="window.timetableLocale.weekdaysShort[d-1]"></th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(week, wi) in monthWeeks" :key="wi">
                                        <tr>
                                            <td class="border-t border-gray-100 align-top text-xs text-indigo-600 font-bold px-2 py-1 text-center cursor-pointer hover:bg-indigo-100/60"
                                                @click="view = 'week'; weekStart = new Date(week[0].date.getFullYear(), week[0].date.getMonth(), week[0].date.getDate())"
                                                x-text="week[0].weekNr"></td>
                                            <template x-for="day in week" :key="day.key">
                                                <td class="border-t border-gray-100 align-top min-w-[48px] h-10 px-2 py-1 cursor-pointer relative group transition-colors duration-100 hover:z-10 hover:shadow-lg hover:bg-indigo-100/60"
                                                    @click="if(day.label){ view = 'day'; dayDate = new Date(day.date.getFullYear(), day.date.getMonth(), day.date.getDate()) }"
                                                    x-text="day.label"></td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Year View -->
                    <div x-show="view === 'year'" class="overflow-x-auto">
                        <div class="flex items-center mb-6">
                            <button class="px-3 py-1 bg-gray-200 rounded mr-2" @click="prevYear">&#8592;</button>
                            <span class="font-semibold text-lg mx-2" x-text="yearLabel"></span>
                            <button class="px-3 py-1 bg-gray-200 rounded ml-2" @click="nextYear">&#8594;</button>
                        </div>
                        <div class="grid grid-cols-4 gap-4">
                            <template x-for="(month, mi) in yearMonths" :key="month.key">
                                <div class="border border-gray-200 rounded-lg bg-white hover:bg-indigo-100/60 transition-colors cursor-pointer flex flex-col items-center justify-center p-4 min-h-[90px] shadow group"
                                    @click="view = 'month'; monthDate = new Date(yearDate.getFullYear(), mi, 1)">
                                    <span class="font-bold text-gray-700 text-lg mb-2" x-text="month.label"></span>
                                    <div class="w-full grid grid-cols-7 gap-1">
                                        <template x-for="d in month.days" :key="d.key">
                                            <span class="text-xs text-gray-400 text-right" x-text="d.label"></span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.timetableLocale = {
            weekdaysShort: @json(__('crm::timetable.weekdaysShort')),
        };
        function getWeekNumber(date) {
            // Copy date so don't modify original
            const d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()));
            // Set to nearest Thursday: current date + 4 - current day number
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
            // Get first day of year
            const yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
            // Calculate full weeks to nearest Thursday
            const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1)/7);
            return weekNo;
        }
        function timetableView() {
            return {
                view: 'week',
                // Week logic
                weekStart: new Date(2025, 3, 28), // 28 April 2025
                get weekLabel() {
                    const end = new Date(this.weekStart); end.setDate(end.getDate() + 6);
                    return `${this.weekStart.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' })} - ${end.toLocaleDateString('en-GB', { day: '2-digit', month: 'short' })}`;
                },
                get weekDays() {
                    const days = [];
                    for (let i = 0; i < 7; i++) {
                        const d = new Date(this.weekStart); d.setDate(d.getDate() + i);
                        days.push(d.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' }));
                    }
                    return days;
                },
                get weekRows() {
                    const rows = [];
                    for (let hour = 9; hour < 18; hour++) {
                        for (let q = 0; q < 4; q++) {
                            const min = q * 15;
                            rows.push({ key: `${hour}:${min}`, time: `${hour.toString().padStart(2, '0')}:${min === 0 ? '00' : min}` });
                        }
                    }
                    return rows;
                },
                prevWeek() { this.weekStart = new Date(this.weekStart.getFullYear(), this.weekStart.getMonth(), this.weekStart.getDate() - 7); },
                nextWeek() { this.weekStart = new Date(this.weekStart.getFullYear(), this.weekStart.getMonth(), this.weekStart.getDate() + 7); },

                // Day logic
                dayDate: new Date(2025, 3, 28), // 28 April 2025
                get dayLabel() {
                    return this.dayDate.toLocaleDateString('en-GB', { weekday: 'long', day: '2-digit', month: 'short' });
                },
                get dayRows() {
                    const rows = [];
                    for (let hour = 9; hour < 18; hour++) {
                        for (let q = 0; q < 4; q++) {
                            const min = q * 15;
                            rows.push({ key: `${hour}:${min}`, time: `${hour.toString().padStart(2, '0')}:${min === 0 ? '00' : min}` });
                        }
                    }
                    return rows;
                },
                prevDay() { this.dayDate = new Date(this.dayDate.getFullYear(), this.dayDate.getMonth(), this.dayDate.getDate() - 1); },
                nextDay() { this.dayDate = new Date(this.dayDate.getFullYear(), this.dayDate.getMonth(), this.dayDate.getDate() + 1); },

                // Month logic
                monthDate: new Date(2025, 3, 1), // April 2025
                get monthLabel() {
                    return this.monthDate.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
                },
                get monthWeeks() {
                    // Returns array of weeks, each week is array of 7 day objects
                    const days = [];
                    const firstDay = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth(), 1);
                    let weekday = firstDay.getDay() || 7;
                    for (let i = 1; i < weekday; i++) days.push({ key: `empty-${i}`, label: '', date: null });
                    const daysInMonth = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth() + 1, 0).getDate();
                    for (let d = 1; d <= daysInMonth; d++) {
                        const date = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth(), d);
                        days.push({ key: `day-${d}`, label: d, date, weekNr: getWeekNumber(date) });
                    }
                    while (days.length % 7 !== 0) days.push({ key: `empty-end-${days.length}`, label: '', date: null });
                    // Split into weeks
                    const weeks = [];
                    for (let i = 0; i < days.length; i += 7) {
                        const week = days.slice(i, i+7);
                        // weekNr is from first non-empty day in week
                        let weekNr = '';
                        for (const day of week) { if(day.label && day.weekNr){ weekNr = day.weekNr; break; } }
                        week.forEach(day => { day.weekNr = weekNr; });
                        weeks.push(week);
                    }
                    return weeks;
                },
                prevMonth() { this.monthDate = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth() - 1, 1); },
                nextMonth() { this.monthDate = new Date(this.monthDate.getFullYear(), this.monthDate.getMonth() + 1, 1); },

                // Year logic
                yearDate: new Date(2025, 0, 1), // 2025
                get yearLabel() {
                    return this.yearDate.getFullYear();
                },
                get yearMonths() {
                    const months = [];
                    for (let m = 0; m < 12; m++) {
                        const month = new Date(this.yearDate.getFullYear(), m, 1);
                        const label = month.toLocaleDateString('en-GB', { month: 'long' });
                        // Days grid for each month (only numbers, no weekday headers)
                        const days = [];
                        const firstDay = new Date(month.getFullYear(), month.getMonth(), 1);
                        let weekday = firstDay.getDay() || 7;
                        for (let i = 1; i < weekday; i++) days.push({ key: `empty-${m}-${i}`, label: '' });
                        const daysInMonth = new Date(month.getFullYear(), month.getMonth() + 1, 0).getDate();
                        for (let d = 1; d <= daysInMonth; d++) {
                            days.push({ key: `day-${m}-${d}`, label: d });
                        }
                        while (days.length % 7 !== 0) days.push({ key: `empty-end-${m}-${days.length}`, label: '' });
                        months.push({ key: `month-${m}`, label, days });
                    }
                    return months;
                },
                prevYear() { this.yearDate = new Date(this.yearDate.getFullYear() - 1, 0, 1); },
                nextYear() { this.yearDate = new Date(this.yearDate.getFullYear() + 1, 0, 1); }
            }
        }
    </script>
</x-app-layout>
