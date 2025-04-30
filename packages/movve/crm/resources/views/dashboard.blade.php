<x-app-layout>
    <div class="container mx-auto py-8">
        {{-- Welkom blok --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                {{ __('crm::dashboard.welcome', ['name' => Auth::user()->name]) }}
            </h1>
        </div>

        {{-- Rapporten blok --}}
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 md:mb-0">
                    {{ __('crm::dashboard.reports_for') }}
                    <span id="dashboard-month-label">{{ now()->translatedFormat('F Y') }}</span>
                </h2>
                {{-- Maand selector --}}
                <form method="GET" class="flex gap-2 items-center">
                    <button type="submit" name="month" value="{{ now()->subMonth()->format('Y-m') }}" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">&lt;</button>
                    <span class="font-medium">{{ request('month', now()->format('Y-m')) }}</span>
                    <button type="submit" name="month" value="{{ now()->addMonth()->format('Y-m') }}" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">&gt;</button>
                </form>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Nieuwe gebruikers --}}
                <div class="bg-blue-50 rounded p-5 flex flex-col items-center">
                    <div class="text-3xl font-bold text-blue-700">{{ $newUsers ?? 0 }}</div>
                    <div class="text-gray-600 mt-2">{{ __('crm::dashboard.new_users') }}</div>
                </div>
                {{-- Bookingen --}}
                <div class="bg-green-50 rounded p-5 flex flex-col items-center">
                    <div class="text-3xl font-bold text-green-700">{{ $bookings ?? 0 }}</div>
                    <div class="text-gray-600 mt-2">{{ __('crm::dashboard.bookings') }}</div>
                </div>
                {{-- Earned --}}
                <div class="bg-yellow-50 rounded p-5 flex flex-col items-center">
                    <div class="text-3xl font-bold text-yellow-700">€ {{ number_format($earned ?? 0, 2, ',', '.') }}</div>
                    <div class="text-gray-600 mt-2">{{ __('crm::dashboard.earned') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
