<x-app-layout>
    <script type='module'>
        let characters = {{ Js::from($characters) }};
        let hasAliveChar = {{ Js::from($hasAliveChar) }};

        initializePage();

        function initializePage() {
            if(characters.length > 0) {
                //check if user has an alive character and any dead characters
                let hasDeadChar = false;
                let hasAliveChar = false;
                let aliveChar = null;
                for(let index in characters) {
                    let character = characters[index];
                    if(character['status'] == 0) {
                        hasAliveChar = true;
                        aliveChar = character;
                    } else if (character['status'] == 1) {
                        hasDeadChar = true;
                    }
                }

                //if they have an alive char, go on
                if(hasAliveChar) {
                    $('#aliveChar').append(`
                        <div>
                            ${aliveChar['name']} - ${aliveChar['rank']}
                        </div>
                        <div class='flex justify-center mt-4'>
                            <x-primary-button onclick="location.href='{{ route('dashboard.admin') }}'">{{ __('Play') }}</x-primary-button>
                        </div>
                    `);
                } else {
                    $('#aliveChar').append(`
                        {{ __("You have no alive characters!") }}
                        <div class='flex justify-center mt-4'>
                            <x-primary-button onclick="location.href='{{ route('character.create') }}'">{{ __('Create a character') }}</x-primary-button>
                        </div>
                    `);
                }

                //if they have dead chars, assemble the table for them
                if(hasDeadChar) {
                    let tableHTML = `
                    <h4>Dead Characters</h4>
                    <x-table id='deadCharTable' tableClass='' tableBodyId='deadCharTableBody'>
                        <x-slot name='head'>
                            <tr>
                                <th scope='col'>Name</th>
                                <th scope='col'>Rank</th>
                                <th scope='col'>Died On</th>
                            </tr>
                        </x-slot>

                        <x-slot name='body'>
                    `;
                    for(let index in characters) {
                        let character = characters[index];
                        if (character['status'] == 1) {
                            tableHTML += `
                                <tr>
                                    <td>${character['name']}</td>
                                    <td>${character['rank']}</td>
                                    <td>${character['diedAt']}</td>
                                </tr>
                            `;
                        }
                    }
                    tableHTML += `</x-slot></x-table>`;
                    $('#aliveChar').after(tableHTML);
                }

            }
        }
    </script>

    <x-slot name="header">
        <x-character-header :hasAliveChar=$hasAliveChar />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    @if(count($characters) == 0)
                        {{ __("You have no characters!") }}
                        <div class='flex justify-center mt-4'>
                            <x-primary-button onclick="location.href='{{ route('character.create') }}'">{{ __('Create a character') }}</x-primary-button>
                        </div>
                    @else
                        <div id='aliveChar'></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
