<?php

use Illuminate\Support\Facades\Http;
use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;

new class extends Component {
    use WireToast;

    public $route;
    public $fields;
    public $properties = [];

    public function mount()
    {
        $this->resetProperties();
    }

    function resetProperties(): void
    {
        foreach ($this->fields as $field) {
            $this->properties[$field] = "";
        }
    }

    public function sendCreationData()
    {
        $model = array_map(function ($value) {
            return $value;
        }, $this->properties);

        $response = Http::post('http://localhost:5202/api/' . $this->route, $model);
        if (!$response->created()) {
           toast()
               ->danger('Error while creating', "Cannot create the asset. Try again later")
               ->push();
            return;
        }
        $assetType = __($this->route);
        toast()
            ->success("$assetType successfully created!")
            ->push();

        $json = $response->json();

        $model = array_map(function ($value) {
            return $value;
        }, $json);

        $model['additionalClasses'] = "row__new";

        $this->dispatch('new-row', data: $model);
        $this->resetProperties();


        // dd($model);
    }
}
?>

<div>
    @foreach ($this->properties as $key => $property)
        <div class="py-2 px-4 gap-4 flex flex-row justify-between items-center" wire:key=$key>
            <div>
                <p class="text-lg font-bold">{{ __($key) }}:</p>
            </div>
            <div class="flex gap-2 items-center">
                <input type="text" wire:model="properties.{{ $key }}" class="bg-transparent"/>
            </div>
        </div>
    @endforeach
    <div class="py-4 flex justify-end">
        <button type="button" wire:click='sendCreationData'
                class="bg-green-600 px-4 py-2 rounded-lg hover:bg-green-800 transition-colors">{{__("Create new")}}</button>
    </div>
</div>
