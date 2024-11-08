<?php

use Illuminate\Support\Facades\Http;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $title;
    public $headers;
    public $route;
    public $contents;
    public $secondaryButtonIcon;
    public $secondaryButtonAction;
    public $secondaryButtonTitle;
    public $massDeleteOption = false;

    public $rows = [];
    public $selectedRows = [];

    public function mount()
    {
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

    #[On('new-row')]
    public function newRow($data)
    {
        $tableRow = [];
        foreach ($data as $key => $field) {
            $tableRow[$key] = $field;
        }
        array_unshift($this->rows, $tableRow);
    }

    public function secondaryButtonActionFunction($id)
    {

        //TODO: MAKE IT DO MORE THINGS THAN JUST DELETE
        // dd(Http::post('http://localhost:5202/api/'.$this->route.$this->secondaryButtonAction.'/'.$id));
        Http::delete('http://localhost:5202/api/' . $this->route . '/' . $id);
        // dd($this->rows);
        // dd(array($this->searchForId($id, $this->rows)));
        // dd(array_diff($this->rows, array($this->searchForId($id, $this->rows))));
        unset($this->rows[$this->searchForId($id, $this->rows)]);

    }

    function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }


    public function toggleRowSelection($rowId)
    {
        if (in_array($rowId, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$rowId]);
            $this->rows[$this->searchForId($rowId, $this->rows)]['additionalClasses'] = "";
        } else {
            $this->selectedRows[] = $rowId;
            $this->rows[$this->searchForId($rowId, $this->rows)]['additionalClasses'] = "row__selected";
        }
    }

    public function deleteSelectedRows()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        $model = [
            'iDsToDelete' => $this->selectedRows,
        ];

        $this->rows = array_filter($this->rows, function ($row) {
            return !in_array($row['id'], $this->selectedRows);
        });

        $this->selectedRows = [];

        // dd($model);

        Http::post('http://localhost:5202/api/' . $this->route . '/delete-many', $model);
    }
};
?>

<div class="">
    <div class="flex gap-4 flex-col">
        <div class="w-full flex justify-between items-center gap-2 pb-4">
            <h1 class="text-xl">{{ __($title) }}</h1>
            @if ($this->massDeleteOption)
                <div class="flex items-center gap-4">
                    <p>
                        {{ __('Choosen items') }}: <span id="choosenCount">{{ count($selectedRows) }}</span>
                    </p>
                    <button
                        class="transition-colors bg-red-600 @if (count($selectedRows) <= 0) bg-transparent @endif p-3 grid place-items-center"
                        @if (count($selectedRows) <= 0) disabled @endif wire:confirm="{{ __('Are you sure?') }}"
                        wire:click="deleteSelectedRows">
                        <i class="text-white fa-solid {{ $secondaryButtonIcon }}"></i>
                    </button>
                </div>
            @endif
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
                <tr class="@if (isset($row['additionalClasses'])) {{$row['additionalClasses']}} @endif">
                    <td wire:click="toggleRowSelection({{ $row['id'] }})" class="cursor-pointer">
                        <input type="checkbox" name=""
                               class="bg-transparent outline-none border-white pointer-events-none"
                               @if (in_array($row['id'], $selectedRows)) checked @endif />
                    </td>
                    @foreach ($row as $key => $field)
                        @if ($key !== 'additionalClasses')
                            <td>{{ $field }}</td>
                        @endif
                    @endforeach
                    <td>
                        <a href="{{ url($route, ['id' => $row['id']]) }}" class="w-full">
                            <i class="text-blue-500 fa-solid fa-magnifying-glass"></i>
                        </a>
                    </td>
                    <td>
                        <button type="button" class="w-full" title="{{ $secondaryButtonTitle }}"
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
