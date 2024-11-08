<?php

use Livewire\Volt\Component;

new class extends Component {
    public $properties;
    public $route;
    public $editMode = [];

    public function mount()
    {
        // $this->fetchData();
        // Initialize input visibility for each item
        foreach ($this->properties as $index => $property) {
            $this->editMode[$index] = false; // Or false if you want it hidden initially
        }
    }

    public function toggleEditMode($index)
    {
        $this->editMode[$index] = !$this->editMode[$index];
    }

    public function updateModel()
    {
        
        // // Optionally, you can add a success message or reset values here
        // dd("WORKING!");
        $model = [];
        foreach ($this->properties as $key => $value) {
            $model[$key] = $value;
        }
        // dd($json);
        // dd('http://localhost:5202/api/recipient/'.$this->properties["id"]);
        $response = Http::put('http://localhost:5202/api/'.$this->route.'/'.$this->properties["id"], $model);
        if ($response->ok()) {
            session()->flash('message', 'Recipient update successfully!');
        }
        else {
            session()->flash('message', 'Recipient update error.');
        }
    }
};
?>

<div>
    <form wire:submit="updateModel">
        <div class="flex justify-between items-center border-b border-gray-400 my-4">
            <p class="text-gray-400 uppercase font-mono font-bold" style="font-variant: small-caps">{{ __('Details') }}
            </p>
            <button type="submit" class="hover:bg-green-600 transition-colors text-white grid place-items-center">
                <p class="uppercase px-2 py-2 font-bold">
                    Save &nbsp; <i class="fa-solid fa-floppy-disk"></i>
                </p>
            </button>
        </div>
        {{-- {{dd($properties)}} --}}
        @foreach ($properties as $key => $property)
            @if (!is_array($property))
                {{-- {{var_dump(key($property[0]))}} --}}
                <div class="py-2 px-4 gap-4 flex flex-row justify-between items-center" wire:key=$key>
                    <div>
                        <p class="text-lg font-bold">{{ __($key) }}:</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        @if ($editMode[$key] ?? true)
                            <input type="text" wire:model="properties.{{ $key }}" class="bg-transparent" />
                        @else
                            <p class="text-lg"> {{ $property }}</p>
                        @endif
                        @if ($key != 'id')
                            <button
                                type="button"
                                class="grid place-items-center aspect-square p-2 rounded-md {{ $editMode[$key] ? 'bg-green-600' : 'bg-blue-500' }}"
                                wire:click="toggleEditMode('{{ $key }}')">
                                <i
                                    class="text-white fa-solid {{ $editMode[$key] ? 'fa-check' : 'fa-pen-to-square' }}"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </form>
</div>
