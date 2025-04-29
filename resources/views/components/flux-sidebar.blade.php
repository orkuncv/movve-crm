<x-flux-sidebar class="min-h-screen">
    <x-flux-sidebar.logo>
        <span class="font-bold text-xl">Movve</span>
    </x-flux-sidebar.logo>

    <x-flux-sidebar.nav>
        <x-flux-sidebar.link :href="route('dashboard', app()->getLocale())" :active="request()->routeIs('dashboard')" icon="heroicon-o-home">
            Dashboard
        </x-flux-sidebar.link>
        <x-flux-sidebar.link :href="url(app()->getLocale().'/crm/contacts')" :active="request()->routeIs('crm.contacts.*')" icon="heroicon-o-users">
            Contacts
        </x-flux-sidebar.link>
        <x-flux-sidebar.link :href="route('crm.timetable.index', app()->getLocale())" :active="request()->routeIs('crm.timetable.*')" icon="heroicon-o-calendar">
            Timetable
        </x-flux-sidebar.link>
        <x-flux-sidebar.link :href="url(app()->getLocale().'/crm/services')" :active="request()->is(app()->getLocale().'/crm/services*')" icon="heroicon-o-cog">
            Services
        </x-flux-sidebar.link>
    </x-flux-sidebar.nav>

    <x-flux-sidebar.footer>
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <img src="{{ Auth::user()->profile_photo_url ?? '' }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover" />
                <div>
                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <x-flux-sidebar.link :href="route('profile.show', app()->getLocale())" icon="heroicon-o-user">
                Profile
            </x-flux-sidebar.link>
            <form method="POST" action="{{ route('logout', app()->getLocale()) }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                    <x-flux-icon name="heroicon-o-logout" class="w-5 h-5" />
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </x-flux-sidebar.footer>
</x-flux-sidebar>
