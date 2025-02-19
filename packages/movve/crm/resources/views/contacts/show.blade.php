<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Contact') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('crm.contacts.edit', $contact) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('crm.contacts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <x-label value="{{ __('First Name') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->first_name }}
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <x-label value="{{ __('Last Name') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->last_name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <x-label value="{{ __('Email') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->email }}
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <x-label value="{{ __('Phone Number') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->phone_number ?? '-' }}
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-label value="{{ __('Date of Birth') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->date_of_birth ? $contact->date_of_birth->format('Y-m-d') : '-' }}
                            </div>
                        </div>

                        <!-- Created At -->
                        <div>
                            <x-label value="{{ __('Created At') }}" />
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                {{ $contact->created_at->format('Y-m-d H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
