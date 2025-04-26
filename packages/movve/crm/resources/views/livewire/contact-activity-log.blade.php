<div>
    <div class="bg-white overflow-hidden sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('crm::crm.activity_log') }}</h3>

        @if(count($activities) > 0)
            <div class="space-y-4">
                @foreach($activities as $activity)
                    <div class="border-b border-gray-200 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $activity->created_at->format('d-m-Y H:i') }}
                                    @if($activity->user)
                                        {{ __('crm::crm.by_user', ['user' => $activity->user->name]) }}
                                    @endif
                                </p>
                            </div>

                            @if($activity->action === 'updated' && !empty($activity->properties))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ __('crm::crm.updated') }}
                                </span>
                            @elseif($activity->action === 'created')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('crm::crm.created') }}
                                </span>
                            @elseif($activity->action === 'counter_incremented')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ __('crm::crm.counter') }}
                                </span>
                            @elseif($activity->action === 'note_added')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('crm::crm.note') }}
                                </span>
                            @elseif(str_starts_with($activity->action, 'api_'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ __('crm::crm.api') }}
                                </span>
                            @endif
                        </div>

                        @if($activity->action === 'updated' && !empty($activity->properties))
                            <div class="mt-2 text-xs">
                                <details class="cursor-pointer">
                                    <summary class="text-blue-600 hover:text-blue-800">{{ __('crm::crm.show_changes') }}</summary>
                                    <div class="mt-2 pl-2 border-l-2 border-gray-200">
                                        @foreach($activity->properties as $field => $changes)
                                            <div class="mb-1">
                                                <span class="font-medium">{{ $field }}:</span>
                                                <span class="line-through text-red-600">{{ $changes['old'] ?? '' }}</span>
                                                <span class="text-green-600">{{ $changes['new'] ?? '' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($totalCount > count($activities))
                <div class="mt-4 flex justify-center">
                    <button
                        wire:click="loadMore"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ __('crm::crm.load_more') }}
                        <span class="ml-1 text-gray-500">({{ count($activities) }} / {{ $totalCount }})</span>
                    </button>

                    <button
                        wire:click="toggleShowAll"
                        class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        @if($showAll)
                            {{ __('crm::crm.show_less') }}
                        @else
                            {{ __('crm::crm.show_all') }}
                        @endif
                    </button>
                </div>
            @endif
        @else
            <div class="text-gray-500 text-sm italic">
                {{ __('crm::crm.no_activity_found') }}
            </div>
        @endif
    </div>
</div>
