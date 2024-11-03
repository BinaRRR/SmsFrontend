<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $headers;
    public $route;
    public $contents;
    public $secondaryButtonIcon;
    public $secondaryButtonAction;
    public $secondaryButtonTitle;

    public $rows = [];
    public $selectedRows = [];
    // public $

    public function mount()
    {
        $this->fetchData();
        foreach ($this->contents as $row) {
            $tableRow = [];
            foreach ($row as $key => $field) {
                if (!is_array($field)) {
                    $tableRow[$key] = $field;
                }
            }
            $this->rows[] = $tableRow;
        }
    }

    public function fetchData()
    {
        // $this->contents = Http::get('http://localhost:5202/api/'.$this->route)->json();
    }

    public function secondaryButtonActionFunction($id)
    {
        // dd(Http::post('http://localhost:5202/api/'.$this->route.$this->secondaryButtonAction.'/'.$id));
    }

    public function toggleRowSelection($rowId) {
        if (in_array($rowId, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$rowId]);
        }
        else {
            $this->selectedRows[] = $rowId;
        }
    }

    public function deleteCurrentRows() {{
        if (empty($this->selectedRows)) {
            return;
        }
        dd($this->selectedRows);
    }}
};
?>

<div class="">
    <div class="flex gap-4 flex-col">
        <div class="w-full flex justify-between items-center gap-2 pb-4">
            <h1 class="text-xl">{{ __($title) }}</h1>
            <div class="flex items-center gap-4">
                <p>
                    {{ __('Choosen items') }}: <span id="choosenCount">{{ count($selectedRows) }}</span>
                </p>
                <button
                class="transition-colors bg-red-600 @if (count($selectedRows) <= 0) bg-transparent @endif p-3 grid place-items-center"
                @if (count($selectedRows) <= 0) disabled @endif
                wire:click="deleteCurrentRows"
                >
                    <i class="text-white fa-solid {{ $secondaryButtonIcon }}"></i>
                </button>
            </div>
        </div>
        <table class="w-full text-center border-spacing-8 h-full">
            <tr class="text-center">
                <th class="bg-white rounded-tl-xl"></th>
                @foreach ($headers as $header)
                    <th class="bg-white text-black px-8">{{ $header }}</th>
                @endforeach
                <th class="bg-white text-black"></th>
                <th class="bg-white rounded-tr-xl text-black"></th>
            </tr>
            @foreach ($rows as $row)
                <tr>
                    <td wire:click="toggleRowSelection({{ $row['id'] }})" class="cursor-pointer">
                        <input
                            type="checkbox"
                            name=""
                            class="bg-transparent outline-none border-white pointer-events-none"
                            @if (in_array($row['id'], $selectedRows)) checked @endif
                        />
                    </td>
                    @foreach ($row as $field)
                        <td>{{ $field }}</td>
                    @endforeach
                    <td>
                        <a href="{{ url($route, ['id' => $row['id']]) }}" class="w-full">
                            <i class="text-blue-500 fa-solid fa-magnifying-glass"></i>
                    </td>
                    </a>
                    <td>
                        <button class="w-full" title="{{ $secondaryButtonTitle }}"
                            wire:click="secondaryButtonActionFunction({{ $row['id'] }})"
                            wire:confirm="{{ __('Are you sure?') }}">
                            <i class="text-red-600 fa-solid {{ $secondaryButtonIcon }}"></i>
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
        /*let choosenRowsCount = 0;
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
        });*/


        /*
        =====================================
                   MULTI-ROW ACTIONS
        =====================================
        */
    </script>
</div>
