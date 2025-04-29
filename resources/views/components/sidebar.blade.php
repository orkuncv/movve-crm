<aside class="flex flex-col h-screen w-64 bg-white border-r border-gray-200/40">
    <div class="flex items-center h-20 px-8 border-b border-gray-200">
        <span class="font-extrabold text-2xl tracking-tight text-[#251b98] select-none">crm.movve</span>
    </div>
    <div class="flex-1 flex flex-col justify-between">
        <nav class="px-4 pt-6">
            <a href="{{ route('dashboard', app()->getLocale()) }}"
               class="flex items-center w-full px-2 py-2 rounded text-sm font-medium text-gray-900 hover:bg-gray-100 transition mb-1 {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 576 512">
                    <path
                        d="M298.6 4c-6-5.3-15.1-5.3-21.2 0L5.4 244c-6.6 5.8-7.3 16-1.4 22.6s16 7.3 22.6 1.4L64 235l0 197c0 44.2 35.8 80 80 80l288 0c44.2 0 80-35.8 80-80l0-197 37.4 33c6.6 5.8 16.7 5.2 22.6-1.4s5.2-16.7-1.4-22.6L298.6 4zM96 432l0-225.3L288 37.3 480 206.7 480 432c0 26.5-21.5 48-48 48l-64 0 0-160c0-17.7-14.3-32-32-32l-96 0c-17.7 0-32 14.3-32 32l0 160-64 0c-26.5 0-48-21.5-48-48zm144 48l0-160 96 0 0 160-96 0z"/>
                </svg>
                Dashboard
            </a>
            <a href="/{{ app()->getLocale() }}/crm/contacts"
               class="flex items-center w-full px-2 py-2 rounded text-sm font-medium text-gray-900 hover:bg-gray-100 transition mb-1 {{ request()->routeIs('crm.contacts.*') ? 'bg-gray-100' : '' }}">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 640 512">
                    <path
                        d="M96 80a48 48 0 1 1 96 0A48 48 0 1 1 96 80zm128 0A80 80 0 1 0 64 80a80 80 0 1 0 160 0zm96 80a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm0 160a96 96 0 1 0 0-192 96 96 0 1 0 0 192zm-58.7 64l117.3 0c54.2 0 98.4 42.5 101.2 96l-319.7 0c2.8-53.5 47-96 101.2-96zm0-32C187.7 352 128 411.7 128 485.3c0 14.7 11.9 26.7 26.7 26.7l330.7 0c14.7 0 26.7-11.9 26.7-26.7C512 411.7 452.3 352 378.7 352l-117.3 0zM512 32a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm0 128A80 80 0 1 0 512 0a80 80 0 1 0 0 160zm16 64c44.2 0 80 35.8 80 80c0 8.8 7.2 16 16 16s16-7.2 16-16c0-61.9-50.1-112-112-112l-84 0c2.6 10.2 4 21 4 32l80 0zm-336 0c0-11 1.4-21.8 4-32l-84 0C50.1 192 0 242.1 0 304c0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.2 35.8-80 80-80l80 0z"/>
                </svg>
                Contacts
            </a>
            <a href="{{ route('crm.timetable.index', app()->getLocale()) }}"
               class="flex items-center w-full px-2 py-2 rounded text-sm font-medium text-gray-900 hover:bg-gray-100 transition mb-1 {{ request()->routeIs('crm.timetable.*') ? 'bg-gray-100' : '' }}">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 448 512">
                    <path
                        d="M112 0c8.8 0 16 7.2 16 16l0 48 192 0 0-48c0-8.8 7.2-16 16-16s16 7.2 16 16l0 48 32 0c35.3 0 64 28.7 64 64l0 32 0 32 0 256c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 192l0-32 0-32C0 92.7 28.7 64 64 64l32 0 0-48c0-8.8 7.2-16 16-16zM416 192L32 192l0 256c0 17.7 14.3 32 32 32l320 0c17.7 0 32-14.3 32-32l0-256zM384 96L64 96c-17.7 0-32 14.3-32 32l0 32 384 0 0-32c0-17.7-14.3-32-32-32z"/>
                </svg>
                Timetable
            </a>
            <a href="/{{ app()->getLocale() }}/crm/services"
               class="flex items-center w-full px-2 py-2 rounded text-sm font-medium text-gray-900 hover:bg-gray-100 transition mb-1 {{ request()->is(app()->getLocale().'/crm/services*') ? 'bg-gray-100' : '' }}">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M153.8 72.1c8.9-9.9 8.1-25-1.8-33.9s-25-8.1-33.9 1.8L63.1 101.1 41 79C31.6 69.7 16.4 69.7 7 79s-9.4 24.6 0 33.9l40 40c4.7 4.7 11 7.2 17.6 7s12.8-3 17.2-7.9l72-80zm0 160c8.9-9.9 8.1-25-1.8-33.9s-25-8.1-33.9 1.8L63.1 261.1 41 239c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l40 40c4.7 4.7 11 7.2 17.6 7s12.8-3 17.2-7.9l72-80zM216 120l272 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L216 72c-13.3 0-24 10.7-24 24s10.7 24 24 24zM192 256c0 13.3 10.7 24 24 24l272 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-272 0c-13.3 0-24 10.7-24 24zM160 416c0 13.3 10.7 24 24 24l304 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-304 0c-13.3 0-24 10.7-24 24zm-64 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                </svg>
                Services
            </a>
        </nav>
        <div class="px-4 pb-4 flex flex-col gap-3">
            <div class="flex items-center gap-2 text-xs text-gray-400 mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M16 12h.01M12 16h.01"/>
                </svg>
                {{ Auth::user()->name }}
            </div>
            <!-- Team Switcher -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div>
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button type="button"
                                    class="flex items-center gap-2 px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 w-full">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0zm6 4v5"/>
                                </svg>
                                <span class="font-medium">{{ Auth::user()->currentTeam->name }}</span>
                                <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-60">
                                <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Team') }}</div>
                                <x-dropdown-link
                                    href="{{ route('teams.show', [Auth::user()->currentTeam->id, 'locale' => app()->getLocale()]) }}">
                                    {{ __('Team Settings') }}
                                </x-dropdown-link>
                                @if (Auth::user()->allTeams()->count() > 1)
                                    <div class="border-t border-gray-200 my-2"></div>
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Switch Teams') }}</div>
                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team"/>
                                    @endforeach
                                @endif
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
            <!-- Language Switcher -->
            <div>
                <x-language-switcher/>
            </div>
        </div>
    </div>
</aside>
