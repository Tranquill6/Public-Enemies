<x-app-layout>
    <x-slot name="header">
        <x-admin-dashboard-header/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('status') === 'key-generated')
                    <p class="mt-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400">
                        {{ __('A new alpha key has been generated!') }}
                    </p>
                @endif
                @if (session('status') === 'key-generated-failed')
                    <p class="mt-2 p-2 font-medium text-sm text-center text-white bg-red-600 dark:bg-red-400">
                        {{ __('Alpha key has failed to generate!') }}
                    </p>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Every active alpha key is below!") }}
                </div>
                <div class='pl-6 pb-6'>
                    <form method="post" action="{{ route('dashboard.admin.generateAlphaKeys.create') }}">
                        @csrf
                        @method('post')
                        <x-primary-button class='mb-6'>Generate New Key</x-primary-button>
                    </form>
                    @foreach ($keys as $key)
                        <p class='text-white'>{{ $key->key }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
