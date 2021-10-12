<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'jobsCount' => $this->user->company->jobs()->count(),
            'jobs' => $this->user->company->jobs,
            'applicants' => $this->user->company->applicants,
        ]);
    }
}
