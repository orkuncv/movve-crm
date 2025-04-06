<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text">
                {{ __('Contact Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="/{{ app()->getLocale() }}/crm/contacts/{{ $contact->id }}/edit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit Contact') }}
                </a>
                <a href="/{{ app()->getLocale() }}/crm/contacts" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 tracking-wider hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to Contacts') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 lg:p-8">
                    <!-- Contact Header -->
                    <div class="mb-8 flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="flex-shrink-0 h-24 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                            {{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $contact->full_name }}</h3>
                            <div class="flex flex-wrap gap-3">
                                @if($contact->email)
                                <div class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $contact->email }}
                                </div>
                                @endif
                                @if($contact->phone_number)
                                <div class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $contact->phone_number }}
                                </div>
                                @endif
                                @if($contact->date_of_birth)
                                <div class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $contact->date_of_birth->format('d M Y') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">{{ __('Contact Information') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('First Name') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->first_name }}
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('Last Name') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->last_name }}
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('Email') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->email }}
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('Phone Number') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->phone_number ?? '-' }}
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('Date of Birth') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->date_of_birth ? $contact->date_of_birth->format('d M Y') : '-' }}
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="text-sm font-medium text-gray-500 mb-1">{{ __('Created At') }}</div>
                                <div class="text-gray-900 font-medium">
                                    {{ $contact->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Fields Section -->
                    <div class="border-t border-gray-200 mt-8 pt-6">

                        @php
                            $metaFields = \Movve\Crm\Models\TeamMetaField::where('team_id', auth()->user()->currentTeam->id)
                                ->where('is_active', true)
                                ->get();
                        @endphp

                        @if($metaFields->isEmpty())
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 text-center">
                                <div class="text-gray-500">{{ __('No meta fields configured for this team.') }}</div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($metaFields as $metaField)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        @if($metaField->type === 'counter' || $metaField->type === 'count')
                                            @php
                                                $meta = $contact->getMeta($metaField->key);
                                                $counter = $meta ? $meta->counter : 0;
                                            @endphp
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-medium text-gray-700">{{ $metaField->name }}</span>
                                                    <span id="counter-{{ $metaField->key }}" class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                        {{ $counter }}
                                                    </span>
                                                </div>
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    onclick="incrementCounter('{{ $contact->id }}', '{{ $metaField->key }}', '{{ csrf_token() }}')"
                                                >
                                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    {{ __('Visited') }}
                                                </button>
                                                <div class="mt-2 text-xs text-gray-500">
                                                    Laatste update: {{ now() }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-sm font-medium text-gray-500 mb-1">{{ $metaField->name }}</div>
                                            <div class="text-gray-900 font-medium">
                                                @php
                                                    $meta = $contact->getMeta($metaField->key);
                                                    $value = $meta ? ($metaField->type === 'boolean' ? ($meta->value ? 'Yes' : 'No') : $meta->value) : '-';
                                                @endphp
                                                {{ $value }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Notities Section -->
                    <div class="border-t border-gray-200 mt-8 pt-6">
                        @php
                            // Haal het notities meta veld op
                            $notesField = \Movve\Crm\Models\TeamMetaField::where('team_id', auth()->user()->currentTeam->id)
                                ->where('key', 'notes')
                                ->where('is_active', true)
                                ->first();

                            // Haal de notities op voor dit contact
                            $notesMeta = null;
                            if ($notesField) {
                                $notesMeta = $contact->getMeta('notes');
                            }
                        @endphp

                        <!-- Weergave van bestaande notities -->
                        @if($notesMeta && $notesMeta->value)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                                <div class="prose max-w-none">
                                    {!! $notesMeta->value !!}
                                </div>
                            </div>
                        @endif

                        <!-- Notities editor -->
                        @livewire('movve.crm.contact-notes-editor', ['contact' => $contact], key('notes-'.$contact->id))
                    </div>

                    <!-- Activiteitenlogboek Section -->
                    <div class="border-t border-gray-200 mt-8 pt-6">
                        @livewire('movve.crm.contact-activity-log', ['contact' => $contact], key('activity-log-'.$contact->id))
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
