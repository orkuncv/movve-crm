<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text">
                {{ __('Services') }}
            </h2>
            <div>
                <a href="/{{ app()->getLocale() }}/crm/services/create"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Service') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ __('Services overzicht') }}</h3>
                <div class="space-y-6">
                    @forelse($services as $service)
                        <div class="p-4 bg-gray-50 rounded-lg shadow flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div>
                                <div class="font-semibold text-lg text-gray-900">{{ $service->name }}</div>
                                <div class="text-gray-600">{{ $service->info }}</div>
                                <div class="text-gray-500 text-sm mt-1">
                                    {{ __('Categorie:') }} {{ $service->category?->name ?? '-' }}
                                    | {{ __('Prijs:') }} {{ $service->price ? ('€ ' . number_format($service->price, 2, ',', '.')) : '-' }}
                                    | {{ __('Duur:') }} {{ $service->duration ? ($service->duration . ' min') : '-' }}
                                </div>
                                <div class="text-gray-500 text-xs mt-1">
                                    {{ __('Medewerkers:') }}
                                    @if($service->staffMembers->count())
                                        {{ $service->staffMembers->pluck('name')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <a href="{{ route('crm.services.show', ['locale' => app()->getLocale(), 'id' => $service->id]) }}" class="inline-flex items-center px-3 py-1 bg-gray-600 text-white text-xs font-semibold rounded hover:bg-gray-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ __('Bekijken') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 italic">{{ __('Nog geen services toegevoegd.') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
