<x-game-layout>
    <script type='module'>
        //make sure any messages fade out after a little bit
        $('#successMsg').delay(4500).fadeOut();
        $('#failMsg').delay(4500).fadeOut();
    </script>

    <x-slot name="header">
        <x-game-header :characterData=$characterData />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('status') === 'travel-success')
                    <p id='successMsg' class="mb-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                @if (session('status') === 'travel-failed')
                    <p id='failMsg' class="mb-2 p-2 font-medium text-sm text-center text-white bg-red-600 dark:bg-red-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                <div class='text-white text-center text-xl w-full mb-4'>{{ __($characterData['location'].' Airport') }}</div>
                <div class='text-white text-center text-md w-full mb-4'>{{ __('The airport is open and it currently costs $100 to fly') }}</div>
                <div class='w-full flex justify-center items-center'>
                    <div class='w-2/4'>
                        <form method='POST' action='{{ route('play.travelCharacter') }}'>
                            @csrf
                            <x-input-label for='travelSpots' class='text-left mb-2' value="{{ __('Choose a location') }}" />
                            <x-selectpicker id='travelSpots' name='travelSpots' labelHidden='true' selectClasses=''>
                                <x-slot name='options'>
                                    @foreach($cities as $city)
                                        @if($city['name'] != $characterData['location'])
                                            <option value='{{ __($city['id']) }}'>{{ __($city['name']) }}</option>
                                        @endif
                                    @endforeach
                                </x-slot>
                            </x-selectpicker>
                            <x-primary-button class='w-full mt-4 justify-center'>Fly</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-game-layout>
