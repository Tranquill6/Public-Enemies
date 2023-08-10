<x-game-layout>
    <script type='module'>
        //Nothing yet
    </script>

    <x-slot name="header">
        <x-game-header :characterData=$characterData />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <span class='text-white'>Welcome to the game! <br> You are currently in {{ $characterData['location'] }}!</span>
            </div>
        </div>
    </div>
</x-game-layout>
