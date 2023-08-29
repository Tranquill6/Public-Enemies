<script type='module'>

</script>

<footer class="sticky bottom-0 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl min-h-14 max-h-48 mx-auto px-4 sm:px-6 lg:px-8 overflow-auto">
        <div class="flex flex-row flex-wrap justify-center py-4">
            <div class='text-white text-xl w-full text-center'>{{ __('Online List') }}</div>
            <div class='inline-flex text-white text-sm w-full justify-center mt-4'>
                @foreach ($lastOnline as $char)
                    <a href='{{ route('play.profile', ['id' => $char->id]) }}'>  
                        {{ __($char->name) }}
                        @if(!$loop->last)
                        |
                        &nbsp;
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

</footer>