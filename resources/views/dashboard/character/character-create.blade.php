<x-app-layout>
    <script type='module'>

    </script>

    <x-slot name="header">
        <x-character-header :hasAliveChar=$hasAliveChar />
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action='{{ route('character.createCharacter') }}'>
                        @csrf

                        <div class='inline-flex w-full flex-row flex-wrap'>
                            <div class='w-full'>
                                <x-input-label for='name' class='text-left mb-2' value="{{ __('Name') }}" />
                                <x-text-input id='name' name='name' class='block w-full' type='text' :value="old('name')" required autocomplete='name' />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterSex' class='text-left' value="{{ __('Sex') }}" />
                                <div class='mt-2 flex justify-evenly'>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterMale' name='characterSex' class='inline-flex' value='Male' checked/>
                                        <x-input-label for='characterSex' class='text-left inline-flex ml-2' value="{{ __('Male') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterFemale' name='characterSex' class='inline-flex' value='Female'/>
                                        <x-input-label for='characterSex' class='text-left inline-flex ml-2' value="{{ __('Female') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterLocation' class='text-left mb-2' value="{{ __('Starting Location') }}" />
                                <x-selectpicker id='characterLocation' name='characterLocation' labelHidden='true' selectClasses=''>
                                    <x-slot name='options'>
                                        <!-- Maybe a better way to write this? -->
                                        @foreach($cities as $city)
                                            @if($city['admin_city'] == 1)
                                                @can('access-admin-cities')
                                                    <option value='{{ __($city['name']) }}'>{{ __($city['name']) }}</option>
                                                @endcan
                                            @endif
                                            @if($city['admin_city'] == 0)
                                                <option value='{{ __($city['name']) }}'>{{ __($city['name']) }}</option>
                                            @endif
                                        @endforeach
                                    </x-slot>
                                </x-selectpicker>
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterQuestions1' class='text-left mb-2' value="{{ __('Questions') }}" />
                                <span class='text-sm'>A local goomba is giving you a lot of hassle on the streets, how do you deal with him?</span>
                                <div class='mt-2 flex flex-col flex-wrap'>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer1' name='characterQuestions1' class='inline-flex' value='shoot' checked/>
                                        <x-input-label for='characterAnswer1' class='text-left inline-flex ml-2' value="{{ __('Pull out your gun and execute him') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer2' name='characterQuestions1' class='inline-flex' value='int'/>
                                        <x-input-label for='characterAnswer2' class='text-left inline-flex ml-2' value="{{ __('Call up your boss and plan a hit') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer3' name='characterQuestions1' class='inline-flex' value='stealth'/>
                                        <x-input-label for='characterAnswer3' class='text-left inline-flex ml-2' value="{{ __('Find him at night and take him out silently') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer4' name='characterQuestions1' class='inline-flex' value='def'/>
                                        <x-input-label for='characterAnswer4' class='text-left inline-flex ml-2' value="{{ __('Talk back to him, you are vested up') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class='w-full mt-4'>
                                <span class='text-sm'>Another family in the city is causing issues, how do you deal with it?</span>
                                <div class='mt-2 flex flex-col flex-wrap'>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer5' name='characterQuestions2' class='inline-flex' value='int' checked/>
                                        <x-input-label for='characterAnswer5' class='text-left inline-flex ml-2' value="{{ __('Organize a sit-down and talk it out') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer6' name='characterQuestions2' class='inline-flex' value='stealth'/>
                                        <x-input-label for='characterAnswer6' class='text-left inline-flex ml-2' value="{{ __('Plan an ambush on one of their capos') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer7' name='characterQuestions2' class='inline-flex' value='def'/>
                                        <x-input-label for='characterAnswer7' class='text-left inline-flex ml-2' value="{{ __('Get all of the cars bulletproofed') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer8' name='characterQuestions2' class='inline-flex' value='shoot'/>
                                        <x-input-label for='characterAnswer8' class='text-left inline-flex ml-2' value="{{ __('Round up the boys and pay a visit to their headquarters') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class='w-full mt-4'>
                                <span class='text-sm'>The boss asks you to take out a loudmouth, how do you do it?</span>
                                <div class='mt-2 flex flex-col flex-wrap'>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer9' name='characterQuestions3' class='inline-flex' value='def' checked/>
                                        <x-input-label for='characterAnswer9' class='text-left inline-flex ml-2' value="{{ __('Keep the gun in the car and use your fists') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer10' name='characterQuestions3' class='inline-flex' value='stealth'/>
                                        <x-input-label for='characterAnswer10' class='text-left inline-flex ml-2' value="{{ __('Catch him sleeping in his home and take him out quietly') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer11' name='characterQuestions3' class='inline-flex' value='shoot'/>
                                        <x-input-label for='characterAnswer11' class='text-left inline-flex ml-2' value="{{ __('Unload a magazine onto him in broad daylight') }}" />
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-radiobox id='characterAnswer12' name='characterQuestions3' class='inline-flex' value='int'/>
                                        <x-input-label for='characterAnswer12' class='text-left inline-flex ml-2' value="{{ __('Stay in the car and let your boys handle it') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class='w-full mt-4'>
                                <x-primary-button class='w-full justify-center'>{{ __('Create') }}</x-primary-button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
