@extends('crm::layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Create Meta Field') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Add a new meta field for contacts in your team.') }}</p>
                </div>

                <form action="/{{ app()->getLocale() }}/crm/team-meta-fields" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Key -->
                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700">{{ __('Key') }}</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="key" id="key" value="{{ old('key') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="shop_visited" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ __('This is the unique identifier for this field. Use snake_case format.') }}</p>
                            @error('key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="counter" {{ old('type') == 'counter' ? 'selected' : '' }}>{{ __('Counter') }}</option>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>{{ __('Boolean') }}</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="/{{ app()->getLocale() }}/crm/team-meta-fields" class="text-sm text-gray-600 hover:text-gray-900 mr-4">{{ __('Cancel') }}</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Create Meta Field') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
