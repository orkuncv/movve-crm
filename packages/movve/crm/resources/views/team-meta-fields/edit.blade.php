@extends('crm::layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Edit Meta Field') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Update the meta field settings.') }}</p>
                </div>

                <form action="/{{ app()->getLocale() }}/crm/team-meta-fields/{{ $metaField->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $metaField->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Key (readonly) -->
                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700">{{ __('Key') }}</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" id="key" value="{{ $metaField->key }}" class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" readonly disabled>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ __('The key cannot be changed after creation.') }}</p>
                        </div>

                        <!-- Type (readonly) -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                            <input type="text" id="type" value="{{ ucfirst($metaField->type) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm" readonly disabled>
                            <p class="mt-1 text-xs text-gray-500">{{ __('The type cannot be changed after creation.') }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $metaField->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_active" name="is_active" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $metaField->is_active ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">{{ __('Active') }}</label>
                                <p class="text-gray-500">{{ __('Inactive meta fields will not be shown on contact pages.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="/{{ app()->getLocale() }}/crm/team-meta-fields" class="text-sm text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Update Meta Field') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
