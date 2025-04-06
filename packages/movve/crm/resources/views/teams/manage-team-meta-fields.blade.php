<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Meta Velden') }}</h3>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Beheer meta velden voor dit team. Meta velden kunnen worden gebruikt om extra informatie over contacten bij te houden, zoals het aantal winkelbezoeken.') }}
            </p>
        </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="space-y-6">
            @if($this->metaFields->isEmpty())
                <div class="flex flex-col items-center justify-center py-6 text-center text-sm text-gray-500">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2">{{ __('Er zijn nog geen meta velden voor dit team.') }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sleutel') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">{{ __('Acties') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($this->metaFields as $metaField)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metaField->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $metaField->key }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($metaField->type) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $metaField->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $metaField->is_active ? __('Actief') : __('Inactief') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button
                                                type="button"
                                                class="text-indigo-600 hover:text-indigo-900"
                                                wire:click="beginMetaFieldEdit({{ $metaField->id }})"
                                            >
                                                {{ __('Bewerken') }}
                                            </button>

                                            <button
                                                type="button"
                                                class="text-red-600 hover:text-red-900"
                                                wire:click="confirmMetaFieldDeletion({{ $metaField->id }})"
                                            >
                                                {{ __('Verwijderen') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="flex justify-end mt-4">
                <x-jet-button wire:click="confirmMetaFieldCreation" wire:loading.attr="disabled">
                    {{ __('Meta Veld Toevoegen') }}
                </x-jet-button>
            </div>
        </div>

        <!-- Meta Veld Modal -->
        <div x-data="{ open: @entangle('confirmingMetaFieldCreation').defer }" x-show="open" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
            <div class="fixed inset-0 transform transition-all" x-on:click="open = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto" x-trap.noscroll.inert="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900">
                        {{ $editingMetaField ? __('Meta Veld Bewerken') : __('Meta Veld Toevoegen') }}
                    </div>

                    <div class="mt-4">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Naam') }}</label>
                        <input id="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="state.name">
                        @error('state.name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    @if(!$editingMetaField)
                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700">{{ __('Sleutel') }}</label>
                            <input id="key" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="state.key" placeholder="shop_visited">
                            <div class="mt-1 text-xs text-gray-500">{{ __('Dit is de unieke identifier voor dit veld. Gebruik snake_case formaat.') }}</div>
                            @error('state.key') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-jet-label for="type" value="{{ __('Type') }}" />
                            <select id="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.type">
                                <option value="counter">{{ __('Teller') }}</option>
                                <option value="text">{{ __('Tekst') }}</option>
                                <option value="boolean">{{ __('Ja/Nee') }}</option>
                            </select>
                            <x-jet-input-error for="state.type" class="mt-2" />
                        </div>
                    @else
                        <div>
                            <label for="key_display" class="block text-sm font-medium text-gray-700">{{ __('Sleutel') }}</label>
                            <input id="key_display" type="text" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" value="{{ $state['key'] }}" disabled readonly>
                            <div class="mt-1 text-xs text-gray-500">{{ __('De sleutel kan niet worden gewijzigd na aanmaken.') }}</div>
                        </div>

                        <div>
                            <label for="type_display" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                            <input id="type_display" type="text" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" value="{{ ucfirst($state['type']) }}" disabled readonly>
                            <div class="mt-1 text-xs text-gray-500">{{ __('Het type kan niet worden gewijzigd na aanmaken.') }}</div>
                        </div>
                    @endif

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Beschrijving') }}</label>
                        <textarea id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model.defer="state.description" rows="3"></textarea>
                        @error('state.description') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_active" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" wire:model.defer="state.is_active">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">{{ __('Actief') }}</label>
                            <p class="text-gray-500">{{ __('Inactieve meta velden worden niet getoond op contact pagina\'s.') }}</p>
                        </div>
                    </div>
                </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" wire:click="$toggle('confirmingMetaFieldCreation')" wire:loading.attr="disabled">
                        {{ __('Annuleren') }}
                    </button>

                    <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3" wire:click="createMetaField" wire:loading.attr="disabled">
                        {{ $editingMetaField ? __('Opslaan') : __('Toevoegen') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Meta Field Confirmation Modal -->
        <div x-data="{ open: @entangle('confirmingMetaFieldDeletion').defer }" x-show="open" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
            <div class="fixed inset-0 transform transition-all" x-on:click="open = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto" x-trap.noscroll.inert="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900">
                        {{ __('Meta Veld Verwijderen') }}
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        {{ __('Weet je zeker dat je dit meta veld wilt verwijderen? Alle bijbehorende meta waarden voor contacten worden ook verwijderd.') }}
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" wire:click="$toggle('confirmingMetaFieldDeletion')" wire:loading.attr="disabled">
                        {{ __('Annuleren') }}
                    </button>

                    <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3" wire:click="deleteMetaField" wire:loading.attr="disabled">
                        {{ __('Verwijderen') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
