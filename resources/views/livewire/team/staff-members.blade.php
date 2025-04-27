<div>
    <x-section-border />
    <x-form-section submit="addStaffMember">
        <x-slot name="title">
            {{ __('Staffmembers') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Add and manage staff members for this team.') }}
        </x-slot>
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="subtitle" value="{{ __('Subtitle') }}" />
                <x-input id="subtitle" type="text" class="mt-1 block w-full" wire:model.defer="subtitle" />
                <x-input-error for="subtitle" class="mt-2" />
            </div>
            <div class="col-span-6">
                <ul class="divide-y divide-gray-200">
                    @forelse($staffMembers as $staff)
                        <li class="flex items-center justify-between py-2">
                            <div>
                                <div class="font-semibold">{{ $staff->name }}</div>
                                <div class="text-xs text-gray-500">{{ $staff->subtitle }}</div>
                            </div>
                            <button type="button" wire:click="removeStaffMember({{ $staff->id }})" class="text-red-500 hover:text-red-700 text-xs">{{ __('Remove') }}</button>
                        </li>
                    @empty
                        <li class="py-2 text-gray-400">{{ __('No staff members yet.') }}</li>
                    @endforelse
                </ul>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Added.') }}
            </x-action-message>
            <x-button>
                {{ __('Add') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
