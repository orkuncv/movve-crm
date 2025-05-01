<div x-data="{ open: @entangle('showModal') }">
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" @click.self="open = false">
        <div class="bg-white rounded-lg shadow-lg max-w-6xl w-full mx-4 p-8 relative overflow-y-auto" style="max-height:90vh;">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <div class="mb-6 flex items-center gap-4">
                <span class="flex items-center bg-[#251b98] text-white rounded-lg px-4 py-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" fill="none"/>
                        <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor"/>
                    </svg>
                    <span class="font-semibold">{{ __('crm::booking.create') }}</span>
                </span>
            </div>
            @include('crm::bookings._form-layout')
        </div>
    </div>
</div>
