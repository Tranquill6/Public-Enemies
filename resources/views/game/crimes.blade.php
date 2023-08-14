<x-game-layout>
    <script type='module'>

        //make sure any messages fade out after a little bit
        $('#crimeSuccess').delay(2500).fadeOut();
        $('#crimeFail').delay(2500).fadeOut();

        //TODO: Add crimes into the db and pull them from there instead of hard-coding them into this page
        //Add other functionality too like actually doing the crimes, etc...
        $('.crimeTile').on('click', function() {
            //if the tile is disabled, do nothing
            if($(this).hasClass('disabledTile')) {
                return;
            }
            $('.crimeTile').removeClass('selectedTile');
            $(this).addClass('selectedTile');
        });
        //Things that will get done when a form submission occurs
        $("form").submit(function(){
            //We need to add this on form submit so it shows up in the POST request
            $('#chosenCrimeId').val($('.crimeTile.selectedTile').attr('tile-id'));
        });
    </script>

    <x-slot name="header">
        <x-game-header :characterData=$characterData />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('status') === 'crime-success')
                    <p id='crimeSuccess' class="mb-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                @if (session('status') === 'crime-failed')
                    <p id='crimeFail' class="mb-2 p-2 font-medium text-sm text-center text-white bg-red-600 dark:bg-red-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                <div class='text-white text-center text-xl w-full mb-4'>{{ __('Crimes') }}</div>
                <form method='POST' action='{{ route('play.commitCrime') }}'>
                    @csrf
                    <div class='w-full inline-flex flex-row flex-wrap'>
                        @foreach ($crimes as $crime)
                            <x-click-tile width='w-1/3' height='h-20' name='crime-{{ $crime["id"] }}' tileId='{{ $crime["id"] }}' type='crime' text='{{ $crime["name"] }}' disabled='{{ $characterData["rankId"] < $crime["rank_id_required"] ? "true" : "false" }}'></x-click-tile>
                        @endforeach
                    </div>
                    <input type="text" class='hidden' id='chosenCrimeId' name='chosenCrimeId' />
                    <div class='flex'>
                        <x-primary-button class='w-full mt-8 justify-center'>Commit Crime</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-game-layout>
