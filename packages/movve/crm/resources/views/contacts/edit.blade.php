<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Contact') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('crm.contacts.show', $contact) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <form method="POST" action="{{ route('crm.contacts.update', $contact) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <x-label for="first_name" value="{{ __('First Name') }}" />
                                <x-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" 
                                    value="{{ old('first_name', $contact->first_name) }}" required autofocus />
                                <x-input-error for="first_name" class="mt-2" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-label for="last_name" value="{{ __('Last Name') }}" />
                                <x-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                    value="{{ old('last_name', $contact->last_name) }}" required />
                                <x-input-error for="last_name" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    value="{{ old('email', $contact->email) }}" required />
                                <x-input-error for="email" class="mt-2" />
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                                <x-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full"
                                    value="{{ old('phone_number', $contact->phone_number) }}" />
                                <x-input-error for="phone_number" class="mt-2" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
                                <x-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full"
                                    value="{{ old('date_of_birth', optional($contact->date_of_birth)->format('Y-m-d')) }}" />
                                <x-input-error for="date_of_birth" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update Contact') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
