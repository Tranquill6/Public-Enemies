<x-game-layout>
    <script type='module'>
        //TODO: Add crimes into the db and pull them from there instead of hard-coding them into this page
        //Add other functionality too like actually doing the crimes, etc...
        $('.crimeTile').on('click', function() {
            $('.crimeTile').removeClass('selectedTile');
            $(this).addClass('selectedTile');
        });
    </script>

    <x-slot name="header">
        <x-game-header :characterData=$characterData />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class='text-white text-center text-xl w-full mb-4'>{{ __('Crimes') }}</div>
                <div class='w-full inline-flex flex-row flex-wrap'>
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #1' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #2' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #3' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #4' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #5' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #6' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #7' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #8' />
                    <x-click-tile width='w-1/3' height='h-20' text='Crime #9' />
                </div>
                <div class='flex'>
                    <x-primary-button class='w-full mt-8 justify-center'>Commit Crime</x-primary-button>
                </div>
            </div>
        </div>
    </div>
</x-game-layout>
