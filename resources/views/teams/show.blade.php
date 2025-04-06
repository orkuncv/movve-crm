<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            <x-section-border />

            <div class="mt-10 sm:mt-0">
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
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Configureer meta velden voor dit team om extra informatie over je contacten bij te houden.') }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-md font-medium text-gray-700 mb-2">{{ __('Meta Velden Toevoegen') }}</h4>
                                <form action="/{{ app()->getLocale() }}/crm/team-meta-fields" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="team_id" value="{{ $team->id }}">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Naam') }}</label>
                                            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Bijv. Winkelbezoeken" required>
                                        </div>

                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                <option value="count">{{ __('Teller') }}</option>
                                                <option value="field">{{ __('Tekstveld') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('Toevoegen') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Bestaande Meta Velden -->
                            <div class="mt-8">
                                <h4 class="text-md font-medium text-gray-700 mb-3">{{ __('Bestaande Meta Velden') }}</h4>
                                
                                @php
                                    $metaFields = \Movve\Crm\Models\TeamMetaField::where('team_id', $team->id)
                                        ->orderBy('name')
                                        ->get();
                                @endphp
                                
                                @if($metaFields->isEmpty())
                                    <p class="text-gray-500 text-sm">{{ __('Nog geen meta velden toegevoegd.') }}</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Naam') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sleutel') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acties') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($metaFields as $metaField)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metaField->name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $metaField->key }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @if($metaField->type === 'count')
                                                                {{ __('Teller') }}
                                                            @elseif($metaField->type === 'field')
                                                                {{ __('Tekstveld') }}
                                                            @else
                                                                {{ $metaField->type }}
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="#" onclick="if(confirm('{{ __('Weet je zeker dat je dit meta veld wilt verwijderen?') }}')) { window.location.href = '/{{ app()->getLocale() }}/crm/team-meta-fields/{{ $metaField->id }}/delete'; } return false;" class="text-red-600 hover:text-red-900">
                                                                {{ __('Verwijderen') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
