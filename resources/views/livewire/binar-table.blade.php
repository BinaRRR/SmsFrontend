<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $title;
    public $headers;
    public $contents;
};
?>

<div class="">
    <div class="flex gap-4 flex-col">
        <div class="w-full flex justify-between items-center gap-2">
            <h1 class="text-xl">{{ __($title) }}</h1>
            <div class="flex items-center gap-4">
                <p>
                    {{ __("Choosen items")}}: <span id="choosenCount">0</span>
                </p>
                <button class="bg-red-600 p-3 grid place-items-center">
                    <i class="text-white fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>
        <table class="w-full text-center border-spacing-8 h-full">
            <tr class="text-center">
                <th class="bg-white rounded-tl-xl"><input type="checkbox" class="bg-transparent outline-none" name="" id=""></th>
                @foreach ($headers as $header)
                    <th class="bg-white text-black px-8">{{ $header }}</th>
                @endforeach
                <th class="bg-white text-black"></th>
                <th class="bg-white rounded-tr-xl text-black"></th>
            </tr>
            @foreach ($contents as $row)
            <tr>
                <td><input type="checkbox" name="" id="record-{{ $row['id'] }}" class="bg-transparent outline-none border-white"></td>
                @foreach ($row as $field)
                    {{-- {{ dd($field) }} --}}
                    @if (!is_array($field))
                        <td>{{ $field }}</td>
                    @endif
                    
                @endforeach
                <td>
                    <button class="w-full">
                        <i class="text-blue-500 fa-solid fa-magnifying-glass"></i></td>
                    </button>
                <td>
                    <button class="w-full">
                        <i class="text-red-600 fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            
        </table>
        
    </div>
    <script>
        /*
        =====================================
                CHECKBOXES AREA CLICK
        =====================================
        */
        let choosenRowsCount = 0;
        let choosenRowsCountLabel = document.querySelector("#choosenCount");

        let checkboxes = document.querySelectorAll("table input[type='checkbox']");
        checkboxes.forEach(c => {
            c.parentElement.addEventListener('click', e => {
                //Clicking on checkbox without this statement will trigger 'check' twice.
                if (e.target == e.currentTarget) {
                    c.checked = !c.checked;
                    c.dispatchEvent(new Event('change'));
                }
            });

            c.addEventListener('change', (e) => {
                if (c.checked)
                    choosenRowsCount++;
                else
                    choosenRowsCount--;

                choosenRowsCountLabel.innerText = choosenRowsCount;
            });
        });


        /*
        =====================================
                   MULTI-ROW ACTIONS
        =====================================
        */


    </script>
</div>
