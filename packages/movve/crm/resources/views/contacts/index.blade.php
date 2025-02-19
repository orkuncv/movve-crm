<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contacts') }}
            </h2>
            <a href="{{ route('crm.contacts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add Contact') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <!-- Search -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route('crm.contacts.index') }}">
                            <x-input
                                type="search"
                                name="search"
                                placeholder="Search contacts..."
                                value="{{ request('search') }}"
                                class="block w-full"
                            />
                        </form>
                    </div>

                    <!-- Contacts Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-left font-bold">
                                    <th class="px-6 py-3 bg-gray-50">Name</th>
                                    <th class="px-6 py-3 bg-gray-50">Email</th>
                                    <th class="px-6 py-3 bg-gray-50">Phone</th>
                                    <th class="px-6 py-3 bg-gray-50">Date of Birth</th>
                                    <th class="px-6 py-3 bg-gray-50">Created At</th>
                                    <th class="px-6 py-3 bg-gray-50">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($contacts as $contact)
                                    <tr>
                                        <td class="px-6 py-4">
                                            {{ $contact->full_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->phone_number ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->date_of_birth ? $contact->date_of_birth->format('Y-m-d') : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('crm.contacts.show', $contact) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ __('View') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No contacts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
