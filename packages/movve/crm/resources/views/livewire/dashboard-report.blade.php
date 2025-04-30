<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 md:mb-0">
            {{ __('Reports for') }}
            <span>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</span>
        </h2>
        <div class="flex gap-2 items-center">
            <button wire:click="previousMonth" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">&lt;</button>
            <span class="font-medium">{{ $month }}</span>
            <button wire:click="nextMonth" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">&gt;</button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 rounded p-5 flex flex-col items-center">
            <div class="text-3xl font-bold text-blue-700">{{ $newUsers }}</div>
            <div class="text-gray-600 mt-2">{{ __('New Users') }}</div>
        </div>
        <div class="bg-green-50 rounded p-5 flex flex-col items-center">
            <div class="text-3xl font-bold text-green-700">{{ $bookings }}</div>
            <div class="text-gray-600 mt-2">{{ __('Bookings') }}</div>
        </div>
        <div class="bg-yellow-50 rounded p-5 flex flex-col items-center">
            <div class="text-3xl font-bold text-yellow-700">€ {{ number_format($earned, 2, ',', '.') }}</div>
            <div class="text-gray-600 mt-2">{{ __('Earned') }}</div>
        </div>
    </div>
</div>
