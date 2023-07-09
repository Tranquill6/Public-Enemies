@section('scripts')
<script type="module">
    $(document).ready(function() {

        //test listener for clicking a button to make sure jquery works with children via template inheritance
        $('#testBtn').on('click', function() {
            $(this).text('Test2');
        });

    });
</script>
@endsection

@extends('base')

@section('main')
<div class='pt-3 flex flex-col'>
    <h1 class="text-3xl font-bold text-center text-white">Mafia World</h1>
    <div class='flex justify-center'>
        <span class='text-white'>Users:
            @foreach ($test as $t)
                {{ $t->username }}
                @if(!$loop->last)
                ,
                @endif
            @endforeach
        </span>
    </div>
    <div class='flex justify-center'>
        <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' type='button' id='testBtn'>Test</button>
    </div>
</div>
@endsection