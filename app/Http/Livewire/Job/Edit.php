<?php

namespace App\Http\Livewire\Job;

use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Edit extends Component
{
    public $job = null;
    public $content = null;

    protected $rules = [
        'job.name' => 'required|string',
        'job.description' => 'required|string',
        'job.amount' => 'required|numeric',
        'job.salary' => 'required|numeric',
        'job.optional_work_from_home' => 'required|numeric',
    ];

    public function mount($job)
    {
        $this->job = $job;
        $this->content = $job->trixRichText[0]->content;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateJob()
    {
        try {
            $this->job->update(['job-trixFields' => [
                'content' => $this->content
            ]]);
            $this->job->save();
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
            'title' => 'Updated',
            'message' => 'Update job was successfully',
        ]);

        return redirect()->to('jobs');
    }

    public function render()
    {
        return view('livewire.job.edit');
    }
}
