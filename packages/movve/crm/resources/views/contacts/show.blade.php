<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text">
                {{ __('crm::crm.contact_details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="/{{ app()->getLocale() }}/crm/contacts/{{ $contact->id }}/edit"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('crm::crm.edit_contact') }}
                </a>
                <a href="/{{ app()->getLocale() }}/crm/contacts"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 tracking-wider hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('crm::crm.back_to_contacts') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div x-data="{ section: 'contact-info' }" class="flex flex-col md:flex-row">
                    <!-- Sidebar -->
                    <nav
                        class="md:w-1/4 w-full border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50 p-0 md:p-6">
                        <ul class="flex md:flex-col flex-row md:space-y-2 space-x-2 md:space-x-0 text-sm font-medium text-gray-700">
                            <li>
                                <button type="button" @click="section = 'contact-info'"
                                        :class="section === 'contact-info' ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                                        class="block w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-50 focus:bg-indigo-200 transition">
                                    {{ __('crm::crm.contact_information') }}
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="section = 'notes'"
                                        :class="section === 'notes' ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                                        class="block w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-50 focus:bg-indigo-200 transition">
                                    {{ __('crm::crm.notes') }}
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="section = 'files'"
                                        :class="section === 'files' ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                                        class="block w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-50 focus:bg-indigo-200 transition">
                                    {{ __('crm::crm.files') }}
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="section = 'activity'"
                                        :class="section === 'activity' ? 'bg-indigo-100 text-indigo-700 font-semibold' : ''"
                                        class="block w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-50 focus:bg-indigo-200 transition">
                                    {{ __('crm::crm.activity') }}
                                </button>
                            </li>
                        </ul>
                        @if($contact->phone_number)
                            <div class="my-6 flex justify-center">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone_number) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm font-semibold hover:bg-green-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-green-500"
                                         fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path
                                            d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                    </svg>
                                    {{ __('crm::crm.chat_on_whatsapp') }}
                                </a>
                            </div>
                        @endif
                    </nav>

                    <!-- Content -->
                    <section class="md:w-3/4 w-full p-6">
                        <div>
                            <!-- Tabs navigation (hidden on md+, visible on mobile) -->
                            <div class="flex md:hidden mb-4 space-x-2">
                                <button @click="section = 'contact-info'"
                                        :class="section === 'contact-info' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                                        class="px-3 py-2 rounded font-semibold text-sm">{{ __('crm::crm.contact_information_short') }}</button>
                                <button @click="section = 'notes'"
                                        :class="section === 'notes' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                                        class="px-3 py-2 rounded font-semibold text-sm">{{ __('crm::crm.notes') }}</button>
                                <button @click="section = 'files'"
                                        :class="section === 'files' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                                        class="px-3 py-2 rounded font-semibold text-sm">{{ __('crm::crm.files') }}</button>
                                <button @click="section = 'activity'"
                                        :class="section === 'activity' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                                        class="px-3 py-2 rounded font-semibold text-sm">{{ __('crm::crm.activity') }}</button>
                            </div>

                            <!-- Contact info -->
                            <div id="contact-info" x-show="section === 'contact-info'" x-cloak>
                                <!-- Contact Header -->
                                <div class="mb-8 flex flex-col md:flex-row items-center md:items-start gap-6">
                                    <div
                                        class="flex-shrink-0 h-24 w-24 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                        {{ substr($contact->first_name, 0, 1) }}{{ substr($contact->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $contact->full_name }}</h3>
                                        <div class="flex flex-wrap gap-3">
                                            @if($contact->email)
                                                <div
                                                    class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $contact->email }}
                                                </div>
                                            @endif
                                            @if($contact->phone_number)
                                                <div
                                                    class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    </svg>
                                                    {{ $contact->phone_number }}
                                                </div>
                                            @endif
                                            @if($contact->date_of_birth)
                                                <div
                                                    class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full text-sm">
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $contact->date_of_birth->format('d M Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.contact_information') }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- First Name -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.first_name') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->first_name }}
                                            </div>
                                        </div>
                                        <!-- Last Name -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.last_name') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->last_name }}
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.email') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->email }}
                                            </div>
                                        </div>
                                        <!-- Phone Number -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.phone_number') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->phone_number ?? '-' }}
                                            </div>
                                        </div>
                                        <!-- Date of Birth -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.date_of_birth') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->date_of_birth ? $contact->date_of_birth->format('d M Y') : '-' }}
                                            </div>
                                        </div>
                                        <!-- Created At -->
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div
                                                class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.created_at') }}</div>
                                            <div class="text-gray-900 font-medium">
                                                {{ $contact->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>

                                        <!-- Contact Meta Fields -->
                                        @php
                                            $metaFields = \Movve\Crm\Models\TeamMetaField::where('team_id', $contact->team_id)
                                                ->where('is_active', true)
                                                ->get();
                                        @endphp
                                        @foreach($metaFields as $metaField)
                                            @php
                                                $meta = $contact->getMeta($metaField->key);
                                                $value = $meta ? ($metaField->type === 'boolean' ? ($meta->value ? __('crm::crm.yes') : __('crm::crm.no')) : ($metaField->type === 'counter' || $metaField->type === 'count' ? $meta->counter : $meta->value)) : '-';
                                            @endphp
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                                <div
                                                    class="text-sm font-medium text-gray-500 mb-1">{{ __('crm::crm.meta_' . $metaField->key) !== 'crm::crm.meta_' . $metaField->key ? __('crm::crm.meta_' . $metaField->key) : $metaField->name }}</div>
                                                <div class="text-gray-900 font-medium">
                                                    {{ $value }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div id="notes" x-show="section === 'notes'" x-cloak>
                                @livewire('movve.crm.contact-notes-editor', ['contact' => $contact], key('notes-'.$contact->id))
                            </div>

                            <!-- Files -->
                            <div id="files" x-show="section === 'files'" x-cloak>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.files') }}</h4>
                                <div class="bg-white p-4 rounded shadow border border-gray-100">
                                    @if($contact->files && $contact->files->count())
                                        <ul class="divide-y divide-gray-100">
                                            @foreach($contact->files as $file)
                                                <li class="py-2 flex items-center justify-between">
                                                    <div>
                                                        <a href="{{ asset('storage/' . $file->file_path) }}"
                                                           target="_blank"
                                                           class="text-indigo-600 hover:underline">{{ $file->original_name }}</a>
                                                        <span class="text-xs text-gray-400 ml-2">({{ number_format($file->size/1024, 1) }} KB)</span>
                                                    </div>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $file->created_at->format('d-m-Y H:i') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-gray-500 italic">{{ __('crm::crm.no_files_uploaded') }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Activity -->
                            <div id="activity" x-show="section === 'activity'" x-cloak>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.activity') }}</h4>
                                @livewire('movve.crm.contact-activity-log', ['contact' => $contact], key('activity-log-'.$contact->id))
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
