<?php

namespace App\Http\Livewire\Candidates;

use Livewire\Component;

class CandidatesFinishLists extends Component
{
    public function render()
    {
        return view('livewire.candidates.candidates-finish-lists', [
            'applicants' => auth()->user()->company->applicants()->where('state', 'finished')->get(),
        ]);
    }
}
