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

    <!-- Notities lijst zonder accordion -->
    <div class="mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.notes') }}</h3>
        @if($notes->count())
            <ul class="divide-y divide-gray-100">
                @foreach($notes as $note)
                    <li class="py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-semibold text-indigo-700">{{ $note->title }}</div>
                                <div class="text-gray-700">{{ $note->content }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $note->created_at->format('d-m-Y H:i') }}</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button wire:click="editNote({{ $note->id }})" class="text-indigo-500 hover:text-indigo-700 text-xs">{{ __('crm::crm.edit') }}</button>
                                <button wire:click="deleteNote({{ $note->id }})" class="text-red-500 hover:text-red-700 text-xs">{{ __('crm::crm.delete') }}</button>
                            </div>
                        </div>
                        @if($note->files && $note->files->count())
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($note->files as $file)
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-indigo-400 hover:underline text-xs">{{ $file->original_name }}</a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-gray-500 italic">{{ __('crm::crm.no_notes_yet') }}</div>
        @endif
    </div>
</div>
