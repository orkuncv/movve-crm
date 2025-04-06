<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Formulier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Test Formulier (Direct POST)</h3>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="/{{ app()->getLocale() }}/crm/test/update-contact/{{ $contact->id }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Voornaam</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $contact->first_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Achternaam</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $contact->last_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input type="email" name="email" id="email" value="{{ $contact->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Contact bijwerken
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Debug Informatie</h3>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p><strong>Contact ID:</strong> {{ $contact->id }}</p>
                        <p><strong>Locale:</strong> {{ app()->getLocale() }}</p>
                        <p><strong>Form action:</strong> /{{ app()->getLocale() }}/crm/test/update-contact/{{ $contact->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
