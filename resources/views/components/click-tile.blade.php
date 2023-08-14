<div name='{{ $name }}' tile-id='{{ $tileId }}' class='{{ $type }}Tile {{ $width }} {{ $height }} hover:bg-gray-700 flex p-6 text-slate-300 {{ $disabled == 'true' ? 'cursor-not-allowed disabledTile' : 'cursor-pointer' }} border-2 border-t border-r border-l border-b border-slate-300 dark:border-slate-300 justify-center items-center transition ease-in-out duration-15'>
    <div class='text-center'>{{ $text }}</div>
    @if($disabled == 'true')
        <i class="fa-solid fa-lock ml-4"></i>
    @endif
</div>