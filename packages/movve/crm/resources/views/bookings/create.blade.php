<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('crm.bookings.index', app()->getLocale()) }}" class="text-[#251b98] hover:underline flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke="currentColor"/>
                </svg>
                {{ __('crm::booking.back_to_list') }}
            </a>
            <div class="flex items-center bg-[#251b98] text-white rounded-lg px-4 py-2 ml-auto">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" fill="none"/>
                    <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor"/>
                </svg>
                <span class="font-semibold">{{ __('crm::booking.create') }}</span>
            </div>
        </div>
        @livewire('movve.crm.booking-form')
    </div>
</x-app-layout>
