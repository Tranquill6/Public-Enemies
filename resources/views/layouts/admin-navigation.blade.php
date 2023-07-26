<div class='inline-flex flex-row ml-5'>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('dashboard.admin.generateAlphaKeys')" :active="request()->routeIs('dashboard.admin.generateAlphaKeys')">
            {{ __('Generate Alpha Keys') }}
        </x-nav-link>
    </div>
</div>