<form wire:submit.prevent="save">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left: Employee, date, time, comment -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-4 min-h-[500px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm::booking.staff_member') }}</label>
            <select wire:model="staff_member_id" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]">
                <option value="">{{ __('crm::booking.choose_staff') }}</option>
                @foreach($staffMembers as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            @error('staff_member_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">{{ __('crm::booking.date') }}</label>
            <input type="date" wire:model="date" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" />
            <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">{{ __('crm::booking.time_and_duration') }}</label>
            <div class="flex gap-2">
                <input type="time" wire:model="start_time" class="w-1/2 rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" />
                <input type="time" wire:model="end_time" class="w-1/2 rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" />
            </div>
            <select wire:model="duration" class="w-full mt-2 rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]">
                <option value="15">15 min.</option>
                <option value="30">30 min.</option>
                <option value="60">1 uur</option>
                <option value="90">1,5 uur</option>
            </select>
            <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">{{ __('crm::booking.comment') }}</label>
            <textarea wire:model="comment" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" rows="3"></textarea>
            @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <!-- Center: Services, status tabs, search, cards -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-4 min-h-[500px]">
            <div class="flex flex-col gap-2 md:flex-row md:gap-2 mb-2">
                <button type="button" class="px-4 py-1 rounded-full border border-gray-200 bg-gray-100 text-gray-700 font-medium text-xs w-full md:w-auto" wire:click="setStatus('pending')">{{ __('crm::booking.status_pending') }}</button>
                <button type="button" class="px-4 py-1 rounded-full border border-green-200 bg-green-50 text-green-800 font-medium text-xs w-full md:w-auto" wire:click="setStatus('arrived')">{{ __('crm::booking.status_arrived') }}</button>
                <button type="button" class="px-4 py-1 rounded-full border border-red-200 bg-red-50 text-red-700 font-medium text-xs w-full md:w-auto" wire:click="setStatus('no_show')">{{ __('crm::booking.status_noshow') }}</button>
                <button type="button" class="px-4 py-1 rounded-full border border-blue-200 bg-blue-50 text-blue-800 font-medium text-xs w-full md:w-auto" wire:click="setStatus('confirmed')">{{ __('crm::booking.status_confirmed') }}</button>
            </div>
            <div class="flex flex-col gap-2 md:flex-row md:gap-2 mb-2">
                <select wire:model="service_id" class="rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98] w-full md:w-auto">
                    <option value="">{{ __('crm::booking.choose_service') }}</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <input type="text" wire:model="service_search" class="rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98] flex-1 w-full md:w-auto" placeholder="{{ __('crm::booking.search_service') }}" />
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">{{ __('crm::booking.popular_services') }}</div>
                <div class="flex flex-col md:flex-row gap-2">
                    @if(count($services))
                        <div class="bg-gray-50 rounded-lg border p-3 flex flex-col items-start w-full md:w-40">
                            <div class="font-semibold">{{ $services[0]->name }}</div>
                            <div class="text-xs text-gray-500">{{ $services[0]->price ?? '-' }} ₺</div>
                            <div class="text-xs text-gray-400">{{ $services[0]->duration ?? '-' }}</div>
                        </div>
                    @else
                        <div class="text-xs text-gray-400 italic">{{ __('crm::services.no_services') }}</div>
                    @endif
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">{{ __('crm::booking.all_services') }}</div>
                <div class="font-medium">@if(count($services)) {{ $services[0]->name }} @endif</div>
            </div>
        </div>
        <!-- Right: Client info, previous clients -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-4 min-h-[500px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm::booking.client_name') }}</label>
            <input type="text" wire:model="client_name" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" placeholder="{{ __('crm::booking.client_name_placeholder') }}" />
            <label class="block text-sm font-medium text-gray-700 mt-2 mb-1">{{ __('crm::booking.phone') }} <span class="text-gray-400" title="{{ __('crm::booking.phone_info') }}">&#9432;</span></label>
            <input type="tel" wire:model="client_phone" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" placeholder="+90 000 000 0000" />
            <label class="block text-sm font-medium text-gray-700 mt-2 mb-1">Email</label>
            <input type="email" wire:model="client_email" class="w-full rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" placeholder="example@gmail.com" />
            <div class="flex items-center mt-2">
                <input type="checkbox" wire:model="book_for_another" id="book_other" class="rounded border-gray-300 focus:border-[#251b98] focus:ring-[#251b98]" />
                <label for="book_other" class="ml-2 text-sm text-gray-700">{{ __('crm::booking.book_for_another') }}</label>
            </div>
            <div class="mt-4">
                <div class="text-xs text-gray-400 mb-1">{{ __('crm::booking.previous_clients') }}</div>
                <div class="text-sm font-medium">Orkun</div>
                <div class="text-xs text-gray-500">+380 64 015-91-29</div>
            </div>
        </div>
    </div>
    <div class="flex justify-end mt-8">
        <button wire:click="cancel" type="button" class="bg-gray-200 text-gray-700 hover:bg-gray-300 mr-2 px-8 py-3 rounded shadow text-lg">{{ __('crm::booking.cancel') }}</button>
        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-3 px-8 rounded shadow text-lg">
            {{ __('crm::booking.save') }}
        </button>
    </div>
</form>
