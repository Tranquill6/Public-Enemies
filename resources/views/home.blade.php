<x-home-layout>
    <script type="module">
        $(document).ready(function() {
        });
    </script>

    <div class='flex flex-wrap flex-row pl-5 pr-5'>
        <div class='w-3/5 inline-flex justify-center align-middle px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg'>
            <div class='pt-3 flex flex-col'>
                <h1 class="text-3xl font-bold text-center text-white">Welcome to Mafia World!</h1>
                <div class='flex flex-col h-full text-white'>
                    <span class='text-xl mt-5'>
                        Mafia World is a game set in the old times of the mafia in America! The time period is the early 1930s, organized crime is starting to decline as organizations like the Federal Bearu of Investigations become more equipped to deal with criminal organizations. The 1930s was a period of famous gangsters such as John Dillinger, Baby Face Nelson, Bonnie and Clyde, Pretty Boy Floyd, Machine Gun Kelly, and Ma Barker. It also became known as the Public Enemies Era when the FBI began to keep "Public Enemies" lists of wanted criminals charged with crimes.
                    </span>
                    <span class='text-xl mt-5'>
                        In the game, you will start as a nobody, trying to make their mark in this cutthroat criminal world with everyone trying to rise above all others. Do not forget those who helped you on your rise to the top, if you make it, because friends come in short supply. As the saying goes, keep your friends close, and keep your enemies closer.
                    </span>
                    <span class='text-xl mt-5'>
                        The world is a dangerous place, and the only thing stopping the local goomba from putting a round in your head will either be your reputation or your quick drawing skills.
                    </span>
                    <span class='text-2xl text-center mt-auto'>
                        Play and rise your way to power or die trying.
                    </span>
                </div>
            </div>
        </div>
        <div class='w-2/5 inline-flex align-middle justify-center overflow-hidden'>
            <img src='{{ asset('img/gangster.png') }}' class='max-w-lg' />
        </div>
    </div>
</x-home-layout>