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
                @if (session('status') === 'profile-success')
                    <p id='successMsg' class="mb-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                @if (session('status') === 'profile-failed')
                    <p id='failMsg' class="mb-2 p-2 font-medium text-sm text-center text-white bg-red-600 dark:bg-red-400">
                        {{ __(session('message')) }}
                    </p>
                @endif
                @if ($profileData != null)
                    <div class='text-white text-center text-xl w-full mb-8'>{{ __('Profile') }}</div>
                    <div class='flex flex-row flex-wrap'>
                        <div class='w-1/2 inline-flex flex-col flex-wrap'>
                            @if($profileData['sex'] == 'Male')
                                <img src='{{ asset('img/default-male.png') }}' class='max-w-lg' />
                            @else
                                <img src='{{ asset('img/default-female.png') }}' class='max-w-lg' />
                            @endif
                        </div>
                        <div class='w-1/2 inline-flex flex-col flex-wrap'>
                            <div class='inline-flex w-full items-baseline justify-around'>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Name <div class='text-xl text-white ml-2'>{{ $profileData['name'] }}</div></div>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Rank <div class='text-xl text-white ml-2'>{{ $profileData['rank'] }}</div></div>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Status <div class='text-xl text-white ml-2'>{{ $profileData['status'] == '0' ? 'Alive' : 'Dead' }}</div></div>
                            </div>
                            <div class='inline-flex w-full items-baseline justify-around mt-4'>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Sex <div class='text-xl text-white ml-2'>{{ $profileData['sex'] }}</div></div>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Crew <div class='text-xl text-white ml-2'>{{ __('N/A') }}</div></div>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Health 
                                    <div class='text-xl text-white ml-2'>
                                    @if($profileData['health'] > 75)
                                        {{ __('High') }}
                                    @elseif($profileData['health'] > 50)
                                        {{ __('Medium') }}
                                    @else
                                        {{ __('Low') }}
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class='inline-flex w-full items-baseline justify-around mt-4'>
                                <div class='text-slate-400 text-sm inline-flex items-end'>Last Active <div class='text-xl text-white ml-2'>{{ $profileData['lastActive'] != null ? $profileData['lastActive'] : __('N/A') }}</div></div>
                                <div class='text-slate-400 text-sm inline-flex items-end'>In Jail? <div class='text-xl text-white ml-2'>{{ $profileData['jailExpiresAt'] == null ? 'No' : 'Yes' }}</div></div>
                            </div>
                            <div class='w-full'>
                                
                            </div>
                        </div>
                    </div>
                @else
                    <div class='text-white text-center text-xl w-full mb-4'>{{ __('Character does not exist!') }}</div>
                @endif
            </div>
        </div>
    </div>
</x-game-layout>
