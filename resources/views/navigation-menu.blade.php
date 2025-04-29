<nav class="h-full flex flex-col bg-blue-50 w-72">
    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-8 px-4 space-y-3">
        <x-nav-link href="{{ route('dashboard', app()->getLocale()) }}" :active="request()->routeIs('dashboard')"
            class="flex items-center gap-4 px-6 py-4 rounded-xl text-lg font-semibold text-blue-900 hover:bg-gray-700/70 hover:text-white active:bg-gray-700/80 active:text-white focus:bg-gray-700/70 focus:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0h-2a2 2 0 01-2-2V7.414a1 1 0 00-.293-.707l-6-6A1 1 0 004 1.414V21a2 2 0 002 2h2" /></svg>
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link href="/{{ app()->getLocale() }}/crm/contacts" :active="request()->routeIs('crm.contacts.*')"
            class="flex items-center gap-4 px-6 py-4 rounded-xl text-lg font-semibold text-blue-900 hover:bg-gray-700/70 hover:text-white active:bg-gray-700/80 active:text-white focus:bg-gray-700/70 focus:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0zm6 4v5" /></svg>
            {{ __('Contacts') }}
        </x-nav-link>
        <x-nav-link href="{{ route('crm.timetable.index', app()->getLocale()) }}" :active="request()->routeIs('crm.timetable.*')"
            class="flex items-center gap-4 px-6 py-4 rounded-xl text-lg font-semibold text-blue-900 hover:bg-gray-700/70 hover:text-white active:bg-gray-700/80 active:text-white focus:bg-gray-700/70 focus:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            {{ __('Timetable') }}
        </x-nav-link>
        <x-nav-link href="/{{ app()->getLocale() }}/crm/services" :active="request()->is(app()->getLocale().'/crm/services*')"
            class="flex items-center gap-4 px-6 py-4 rounded-xl text-lg font-semibold text-blue-900 hover:bg-gray-700/70 hover:text-white active:bg-gray-700/80 active:text-white focus:bg-gray-700/70 focus:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L8 21m8-4l1.75 4M12 3v10m0 0l-3-3m3 3l3-3" /></svg>
            {{ __('Services') }}
        </x-nav-link>
    </div>

    <!-- Bottom Controls (Fixed) -->
    <div class="fixed bottom-0 left-0 w-72 bg-blue-100 border-t border-blue-200 py-4 px-4 flex flex-col gap-4 z-20">
        <!-- Teams Dropdown -->
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <div class="relative">
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-blue-900 bg-white hover:text-blue-700 focus:outline-none focus:bg-blue-50 active:bg-blue-50 transition ease-in-out duration-150 w-full justify-between">
                                {{ Auth::user()->currentTeam->name }}
                                <svg class="ms-2 -me-0.5 w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-60">
                            <div class="block px-4 py-2 text-xs text-blue-400">
                                {{ __('Manage Team') }}
                            </div>
                            <x-dropdown-link href="{{ route('teams.show', [Auth::user()->currentTeam->id, 'locale' => app()->getLocale()]) }}">
                                {{ __('Team Settings') }}
                            </x-dropdown-link>
                            @if (Auth::user()->allTeams()->count() > 1)
                                <div class="border-t border-blue-200"></div>
                                <div class="block px-4 py-2 text-xs text-blue-400">
                                    {{ __('Switch Teams') }}
                                </div>
                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-switchable-team :team="$team" />
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
        <!-- Account/Profile Dropdown -->
        <div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button class="flex text-base border-2 border-transparent rounded-full focus:outline-none focus:border-blue-300 transition">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </button>
                    @else
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-base leading-4 font-medium rounded-md text-blue-900 bg-white hover:text-blue-700 focus:outline-none focus:bg-blue-50 active:bg-blue-50 transition ease-in-out duration-150">
                                {{ Auth::user()->name }}
                                <svg class="ms-2 -me-0.5 w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </button>
                        </span>
                    @endif
                </x-slot>
                <x-slot name="content">
                    <!-- Account Management -->
                    <x-dropdown-link href="{{ route('profile.show', app()->getLocale()) }}">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <x-dropdown-link href="{{ route('logout', app()->getLocale()) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                    <form method="POST" id="logout-form" action="{{ route('logout', app()->getLocale()) }}" class="hidden">
                        @csrf
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
