<?php

namespace App\Http\Livewire\Candidates;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['applicantUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.candidates.index', [
            'applicants' => auth()->user()->company->applicants,
        ]);
    }
}
