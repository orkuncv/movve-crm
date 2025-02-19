@if (Laravel\Fortify\Features::hasApiFeatures())
    <div>
        @livewire('crm.api-token-manager')
    </div>
@endif
