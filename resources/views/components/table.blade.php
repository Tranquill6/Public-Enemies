
<div class="relative overflow-x-auto">
    <table class="{{ $tableClass }} w-full text-{{ $textSize }} text-left text-gray-500 dark:text-gray-400" id='{{ $id }}'>
        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            {{ $head }}
        </thead>
        <tbody id='{{ $tableBodyId }}'>
           {{ $body }}
        </tbody>
    </table>
</div>
