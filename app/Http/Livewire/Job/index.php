<?php

namespace App\Http\Livewire\Job;

use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['jobUpdated' => '$refresh'];

    public $search;

    public function render()
    {
        return view('livewire.job.index', [
            'jobs' => auth()->user()->company->jobs()->search($this->search)->get()
        ]);
    }
}
