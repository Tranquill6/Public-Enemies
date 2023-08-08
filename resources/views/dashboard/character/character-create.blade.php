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

                    <form method="POST" action=''>

                        <div class='inline-flex w-full flex-row flex-wrap'>
                            <div class='w-full'>
                                <x-input-label for='characterName' class='text-left mb-2' value="{{ __('Name') }}" />
                                <x-text-input id='characterName' name='characterName' class='block w-full' type='text' :value="old('characterName')" required autocomplete='characterName' />
                                <x-input-error :messages="$errors->get('characterName')" />
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterSex' class='text-left' value="{{ __('Sex') }}" />
                                <div class='mt-2 flex justify-evenly'>
                                    <div class='inline-flex items-center'>
                                        <x-input-label for='characterSex' class='text-left inline-flex' value="{{ __('Male') }}" />
                                        <x-radiobox id='characterMale' name='characterSex' class='inline-flex ml-2' value='male' checked/>
                                    </div>
                                    <div class='inline-flex items-center'>
                                        <x-input-label for='characterSex' class='text-left inline-flex' value="{{ __('Female') }}" />
                                        <x-radiobox id='characterFemale' name='characterSex' class='inline-flex ml-2' value='female'/>
                                    </div>
                                </div>
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterLocation' class='text-left mb-2' value="{{ __('Starting Location') }}" />
                                <x-selectpicker id='characterLocation' labelHidden='true' selectClasses=''>
                                    <x-slot name='options'>
                                        <option value='Chicago'>{{ __('Chicago') }}</option>
                                        <option value='Detroit'>{{ __('Detroit') }}</option>
                                    </x-slot>
                                </x-selectpicker>
                            </div>

                            <div class='w-full mt-4'>
                                <x-input-label for='characterQuestions1' class='text-left mb-2' value="{{ __('Questions') }}" />
                                <span class='text-sm'>Here is some example text, this will be a question that players can choose an answer to and this will affect their character's stat multipliers!</span>
                                <div class='mt-2'>
                                    <x-input-label for='characterQuestions1' class='text-left inline-flex' value="{{ __('This is an example answer') }}" />
                                    <x-radiobox id='characterAnswer1' name='characterAnswer1' class='inline-flex' value='test1' checked/>
                                    <x-input-label for='characterQuestions1' class='text-left inline-flex ml-4' value="{{ __('This is an example answer with extra even more text') }}" />
                                    <x-radiobox id='characterAnswer2' name='characterAnswer2' class='inline-flex ml-4' value='test2'/>
                                    <x-input-label for='characterQuestions1' class='text-left inline-flex' value="{{ __('This is an example answer') }}" />
                                    <x-radiobox id='characterAnswer3' name='characterAnswer3' class='inline-flex' value='test3' checked/>
                                    <x-input-label for='characterQuestions1' class='text-left inline-flex ml-4' value="{{ __('This is an example answer with extra') }}" />
                                    <x-radiobox id='characterAnswer4' name='characterAnswer4' class='inline-flex ml-4' value='test4'/>
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
