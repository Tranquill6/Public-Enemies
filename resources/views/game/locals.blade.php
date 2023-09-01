<x-game-layout>
    <script type='module'>
        //make sure any messages fade out after a little bit
        $('#successMsg').delay(4500).fadeOut();
        $('#failMsg').delay(4500).fadeOut();
    </script>

    <style>
        {{-- I couldn't figure how to do this in tailwind so yolo --}}
        .userName > a:hover {
            color: white;
            transition: 0.3s ease-in-out;
        }
    </style>

    <x-slot name="header">
        <x-game-header :characterData=$characterData />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class='text-white text-center text-xl w-full mb-4'>{{ __($characterData['location'].' Locals') }}</div>
                <div class='w-full flex justify-center items-center'>
                    <div class='w-2/4'>
                        <x-table id='localsTable' tableBodyId='localsTableBody' textSize='lg' tableClass=''>
                            <x-slot name='head'>
                                <tr>
                                    <th>Name</th>
                                    <th>Rank</th>
                                    <th>In Jail?</th>
                                    <th>Last Seen</th>
                                </tr>
                            </x-slot>
                            <x-slot name='body'>
                                @foreach ($localData as $local)
                                    <tr>
                                        <td class='userName' user-id='{{ $local['id'] }}'><a href='{{ route('play.profile', ['id' => $local['id']]) }}'>{{ $local['name'] }}</a></td>
                                        <td>{{ $local['rank'] }}</td>
                                        <td>{{ $local['jailExpiresAt'] == null ? 'No' : 'Yes' }}</td>
                                        <td>{{ $local['lastActive'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-game-layout>
