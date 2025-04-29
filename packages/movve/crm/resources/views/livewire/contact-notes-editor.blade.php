<div class="bg-white overflow-hidden sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.notes') }}</h3>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Formulier voor nieuwe notitie -->
    <div class="bg-gray-50 p-4 mb-6 rounded-lg border border-gray-200">
        <h4 class="text-md font-medium text-gray-800 mb-3">{{ __('crm::crm.add_note') }}</h4>

        <form wire:submit.prevent="createNote">
            <div class="mb-3">
                <label for="newNoteTitle" class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm::crm.title') }}</label>
                <input
                    type="text"
                    id="newNoteTitle"
                    wire:model="newNoteTitle"
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="{{ __('crm::crm.title_placeholder') }}"
                >
            </div>

            <div class="mb-3">
                <label for="newNoteContent" class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm::crm.content') }}</label>
                <textarea
                    id="newNoteContent"
                    wire:model="newNoteContent"
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    rows="4"
                    placeholder="{{ __('crm::crm.note_placeholder') }}"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="newNoteFiles" class="block text-sm font-medium text-gray-700 mb-1">Bestanden toevoegen</label>
                <input
                    type="file"
                    id="newNoteFiles"
                    wire:model="newNoteFiles"
                    multiple
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                @error('newNoteFiles.*')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
                >
                    {{ __('crm::crm.add_note') }}
                </button>
            </div>
        </form>
    </div>

    <div x-data="{ open: false }" class="mb-6">
        <button type="button"
            @click="open = !open"
            class="w-full flex justify-between items-center px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-md text-indigo-700 font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition mb-2">
            <span>
                <svg :class="{'rotate-90': open}" class="inline h-4 w-4 mr-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                Notities
            </span>
            <span x-text="open ? 'Sluiten' : 'Toon notities'"></span>
        </button>
        <div x-show="open" x-transition class="mt-2">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.notes') }}</h3>

            <!-- Lijst van bestaande notities -->
            <div class="space-y-4">
                @if(count($notes) > 0)
                    @foreach($notes as $note)
                        <div class="border border-gray-200 rounded-md p-4 bg-white hover:bg-gray-50">
                            <div class="flex justify-between items-start mb-2">
                                <h5 class="text-sm font-semibold text-gray-800">{{ $note->title }}</h5>
                                <span class="text-xs text-gray-500">{{ $note->created_at->format('d-m-Y H:i') }}</span>
                            </div>
                            <div class="text-sm text-gray-700">
                                {!! $note->content !!}
                            </div>
                            @if($note->files && $note->files->count())
                                <div class="mt-3">
                                    <div class="text-xs text-gray-500 mb-1">Bijlagen:</div>
                                    <ul class="list-disc ml-5">
                                        @foreach($note->files as $file)
                                            <li>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">
                                                    {{ $file->original_name }}
                                                </a>
                                                <span class="text-gray-400 text-xs">({{ number_format($file->size/1024, 1) }} KB)</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-gray-500 text-sm italic">
                        {{ __('crm::crm.no_notes_found') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
