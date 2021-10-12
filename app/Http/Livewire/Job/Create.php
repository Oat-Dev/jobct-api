<?php

namespace App\Http\Livewire\Job;

use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Create extends Component
{
    public $job = [
        'name' => null,
        'description' => null,
        'job-trixFields' => [
            'content' => null,
        ],
        'amount' => 1,
        'salary' => 0,
        'optional_work_from_home' => true,
    ];

    public function createJob()
    {
        try {
            $job = new Job($this->job);
            $job->company()->associate(auth()->user()->company);
            $job->save();
        } catch (Exception $e) {
            return $this->emit('toastrAdded', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ]);
        }

        Cache::tags(['job'])->flush();

        session()->flash('toastr', [
            'status' => 'success',
            'title' => 'Created',
            'message' => 'Create job was successfully',
        ]);

        return redirect()->to('jobs');
    }

    public function render()
    {
        return view('livewire.job.create');
    }
}
