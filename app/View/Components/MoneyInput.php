<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MoneyInput extends Component
{

    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $name,
        public string  $label = '',
        public ?string $value = null,
    )
    {
        $this->id = 'money-input-' . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.money-input');
    }
}
