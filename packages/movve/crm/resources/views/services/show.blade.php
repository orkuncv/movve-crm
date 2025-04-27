<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text">
                {{ __('Service details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('crm.services.edit', ['locale' => app()->getLocale(), 'id' => $service->id]) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h6m2 2a2 2 0 002-2V7a2 2 0 00-2-2h-7a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    {{ __('Bewerken') }}
                </a>
                <form method="POST" action="{{ route('crm.services.destroy', ['locale' => app()->getLocale(), 'id' => $service->id]) }}" onsubmit="return confirm('Weet je zeker dat je deze service wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Verwijderen') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-lg p-8">
            <h3 class="text-xl font-bold mb-4">{{ $service->name }}</h3>
            <div class="mb-2 text-gray-700">{{ $service->info }}</div>
            <div class="mb-2 text-gray-600">{{ __('Categorie:') }} {{ $service->category?->name ?? '-' }}</div>
            <div class="mb-2 text-gray-600">{{ __('Prijs:') }} {{ $service->price ? ('€ ' . number_format($service->price, 2, ',', '.')) : '-' }}</div>
            <div class="mb-2 text-gray-600">{{ __('Duur:') }} {{ $service->duration ? ($service->duration . ' min') : '-' }}</div>
            <div class="mb-2 text-gray-600">{{ __('Medewerkers:') }}
                @if($service->staffMembers->count())
                    {{ $service->staffMembers->pluck('name')->join(', ') }}
                @else
                    -
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
