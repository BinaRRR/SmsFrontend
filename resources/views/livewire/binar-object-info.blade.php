<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $object;
};
?>
<div>
    @foreach ($object as $prop)
        @if (!is_array($prop))
            <h1>{{ $prop }}</h1>
        @else
            @foreach ($prop as $prop2)
                @if (!is_array($prop2))
                    <h1>{{ $prop2 }}</h1>
                @else
                    @foreach ($prop2 as $prop3)
                    @if (!is_array($prop3))
                        <h1>{{ $prop3 }}</h1>
                    @endif
                @endforeach
                @endif
            @endforeach
        @endif
    @endforeach
</div>
