@if($metaField)
    <div class="flex flex-col space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-gray-700">{{ $metaField->name }}</span>
        </div>
        <div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                {{ $counter }}
            </span>
            <button
                wire:click="increment"
                type="button"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                onclick="console.log('Button clicked'); Livewire.dispatch('increment-counter', { contact_id: {{ $contact->id }}, meta_key: '{{ $metaKey }}' });"
            >
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('Visited') }} ({{ $counter }})
            </button>
        </div>

        <div class="mt-2 text-xs text-gray-500">
            Laatste update: {{ now() }}
        </div>
    </div>
@endif
