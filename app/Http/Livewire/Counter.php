<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0;

    public function render()
    {
        return <<<'blade'
            <div>
                <p>Counter: {{ $count }}</p>
                <button wire:click="increment">increment</button>
            </div>
        blade;
    }

    public function increment()
    {
        $this->count++;
    }
}
