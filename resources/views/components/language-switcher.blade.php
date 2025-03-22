<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="inline-flex border-2 tems-center px-4 py-2 text-sm font-medium text-black bg-transparent rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20">
        @if(App::getLocale() === 'en')
            <span class="flag-icon flag-icon-gb mr-2 rounded-sm"></span>
        @else
            <span class="flag-icon flag-icon-{{ App::getLocale() }} mr-2 rounded-sm"></span>
        @endif
        <span>{{ config('app.available_locales')[App::getLocale()] }}</span>
        <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1" role="menu" aria-orientation="vertical">
            @foreach(config('app.available_locales') as $locale => $language)
                @if($locale !== App::getLocale())
                    <a href="{{ url('language/' . $locale) }}"
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem">
                        @if($locale === 'en')
                            <span class="flag-icon flag-icon-gb mr-2 rounded-sm"></span>
                        @else
                            <span class="flag-icon flag-icon-{{ $locale }} mr-2 rounded-sm"></span>
                        @endif
                        {{ $language }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('languageSwitcher', () => ({
            open: false
        }))
    })
</script>
@endpush
