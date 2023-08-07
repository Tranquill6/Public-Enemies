<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Characters') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(count($characters) == 0)
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("You have no characters!") }}
                    </div>
                @else
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You have characters!") }}
                    @foreach ($characters as $character)
                        <span>{{ $character->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
