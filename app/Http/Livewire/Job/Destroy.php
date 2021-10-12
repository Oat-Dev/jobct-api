<?php

namespace App\Http\Livewire\Job;

use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Destroy extends Component
{
    protected $listeners = ['openModalDeleteJobForm' => 'deleteModal'];

    public $idSelecting = null;

    public $modalDeleteVisible = false;

    /**
     * Prepare Id for delete Job function.
     * 
     * @return int
     */
    public function deleteModal($id)
    {
        $this->modalDeleteVisible = true;

        return $this->idSelecting = $id;
    }

    /**
     * Delete job
     * 
     * @return void
     */
    public function deleteJob()
    {
        try {
            DB::transaction(function () {
                Job::find($this->idSelecting)->delete();
            });

            $this->modalDeleteVisible = false; // Destroy Modal
        } catch (Exception $e) {
            return $this->emit('toastrAdded', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ]);
        }

        $this->emit('toastrAdded', [
            'type' => 'success',
            'title' => 'Deleted',
            'message' => 'Delete a job successfully.',
        ]);
        $this->emit('jobUpdated');
    }

    public function render()
    {
        return view('livewire.job.destroy');
    }
}
