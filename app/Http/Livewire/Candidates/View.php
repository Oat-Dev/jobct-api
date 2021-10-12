<?php

namespace App\Http\Livewire\Candidates;

use Livewire\Component;

class View extends Component
{
    public $applicant;

    public function render()
    {
        return view('livewire.candidates.view') ;
    }
}
