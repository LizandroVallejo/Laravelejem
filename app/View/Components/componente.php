<?php

namespace App\View\Components;

use Illuminate\View\Component;

class componente extends Component
{
    public $mensaje ; 
    public function __construct($mensaje)
    {
        $this->mensaje=$mensaje;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.componente');
    }
}
