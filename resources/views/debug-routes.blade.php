<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl gradient-text">
            {{ __('Debug Routes') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 lg:p-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Route Information</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route Name</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated URL</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">crm.contacts.index</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ route('crm.contacts.index', ['locale' => app()->getLocale()]) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">crm.contacts.create</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ route('crm.contacts.create', ['locale' => app()->getLocale()]) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">crm.contacts.show (ID: 1)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ route('crm.contacts.show', ['locale' => app()->getLocale(), 'contact' => 1]) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">crm.contacts.edit (ID: 1)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ route('crm.contacts.edit', ['locale' => app()->getLocale(), 'contact' => 1]) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mt-8 mb-4">Direct Links</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <a href="/{{ app()->getLocale() }}/crm/contacts" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                View Contacts (Direct URL)
                            </a>
                        </div>
                        
                        <div>
                            <a href="/{{ app()->getLocale() }}/crm/contacts/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                Create Contact (Direct URL)
                            </a>
                        </div>
                        
                        <div>
                            <a href="/{{ app()->getLocale() }}/crm/contacts/1" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                View Contact ID 1 (Direct URL)
                            </a>
                        </div>
                        
                        <div>
                            <a href="/{{ app()->getLocale() }}/crm/contacts/1/edit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                Edit Contact ID 1 (Direct URL)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
