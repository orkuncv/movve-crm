<div class="mt-10 sm:mt-0">
    <x-section-border />
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Staffmembers') }}</h3>
        <p class="text-sm text-gray-600">{{ __('Add and manage staff members for this team.') }}</p>
    </div>
    <form wire:submit.prevent="addStaffMember" class="flex flex-col md:flex-row gap-2 mb-4">
        <input type="text" wire:model.defer="name" placeholder="{{ __('Name') }}" class="border rounded px-3 py-2 w-full md:w-1/3" required>
        <input type="text" wire:model.defer="subtitle" placeholder="{{ __('Subtitle') }}" class="border rounded px-3 py-2 w-full md:w-1/3">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2 rounded">{{ __('Add') }}</button>
    </form>
    <ul class="divide-y divide-gray-200">
        @forelse($staffMembers as $staff)
            <li class="flex items-center justify-between py-2">
                <div>
                    <div class="font-semibold">{{ $staff->name }}</div>
                    <div class="text-xs text-gray-500">{{ $staff->subtitle }}</div>
                </div>
                <button wire:click="removeStaffMember({{ $staff->id }})" class="text-red-500 hover:text-red-700 text-xs">{{ __('Remove') }}</button>
            </li>
        @empty
            <li class="py-2 text-gray-400">{{ __('No staff members yet.') }}</li>
        @endforelse
    </ul>
</div>
