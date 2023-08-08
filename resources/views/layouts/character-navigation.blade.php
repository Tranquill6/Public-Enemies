<div class='inline-flex flex-row ml-5'>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        @if(!$hasAliveChar)
            <x-nav-link :href="route('character.create')" :active="request()->routeIs('character.create')">
                {{ __('Create') }}
            </x-nav-link>
        @endif
    </div>
</div>