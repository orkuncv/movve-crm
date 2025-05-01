<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ __('crm::booking.bookings') }}</h1>
                <div class="bg-[#251b98] text-white rounded-lg flex items-center px-6 py-4 w-fit mb-2">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" fill="none"/>
                        <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor"/>
                    </svg>
                    <div>
                        <div class="text-lg font-semibold">{{ $bookings->total() }}</div>
                        <div class="text-xs opacity-80">{{ __('crm::booking.total_bookings') }}</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-2 md:items-center">
                <form class="flex items-center bg-gray-100 rounded px-2 py-1" action="#" method="GET">
                    <input type="text" name="search" class="bg-transparent focus:outline-none px-2 py-1" placeholder="{{ __('crm::booking.search_placeholder') }}" />
                    <button type="submit" class="text-[#251b98] px-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" stroke="currentColor"/>
                            <path d="M21 21l-4.35-4.35" stroke="currentColor"/>
                        </svg>
                    </button>
                </form>
                <a href="/{{ app()->getLocale() }}/crm/bookings/create"
                   class="bg-[#251b98] hover:bg-[#1a126c] text-white px-4 py-2 rounded shadow font-semibold transition">
                    + {{ __('crm::booking.create') }}
                </a>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('crm::booking.staff_member') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('crm::booking.service') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('crm::booking.contact') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('crm::booking.start_time') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('crm::booking.end_time') }}</th>
                    <th class="px-4 py-2"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $booking->id }}</td>
                        <td class="px-4 py-2">{{ $booking->staffMember->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $booking->service->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $booking->contact->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $booking->start_time }}</td>
                        <td class="px-4 py-2">{{ $booking->end_time }}</td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('crm.bookings.edit', [app()->getLocale(), $booking]) }}" class="text-[#251b98] hover:underline mr-2">{{ __('crm::booking.edit') }}</a>
                            <form method="POST" action="{{ route('crm.bookings.destroy', [app()->getLocale(), $booking]) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('{{ __('crm::booking.delete_confirm') }}')">{{ __('crm::booking.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 py-8">{{ __('crm::booking.no_bookings') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
