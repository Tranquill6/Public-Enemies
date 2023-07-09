<x-home-layout>
    <script type="module">
        $(document).ready(function() {

            //test listener for clicking a button to make sure jquery works with children via template inheritance
            $('#testBtn').on('click', function() {
                $(this).text('Test2');
            });

        });
    </script>

    <div class='flex flex-wrap flex-row pl-5 pr-5'>
        <div class='w-3/5 inline-flex justify-center align-middle px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg'>
            <div class='pt-3 flex flex-col'>
                <h1 class="text-3xl font-bold text-center text-white">Welcome to Mafia World!</h1>
                <div class='flex justify-center'>
                    <span class='text-white'>
                        Mafia World is a game set in the old times of the mafia in America! Play and rise your way to power or die trying.
                    </span>
                </div>
            </div>
        </div>
        <div class='w-4/12 inline-flex align-middle justify-center'>
            <img src='{{ asset('img/gangster.png') }}' class='max-w-lg' />
        </div>
    </div>
</x-home-layout>