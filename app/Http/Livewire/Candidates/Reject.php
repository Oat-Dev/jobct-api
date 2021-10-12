<?php

namespace App\Http\Livewire\Candidates;

use App\Models\Applicant;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reject extends Component
{
    protected $listeners = ['openModalDeleteApplicantForm' => 'deleteModal'];

    public $idSelecting = null;

    public $modalDeleteVisible = false;

    /**
     * Prepare Id for delete Applicant function.
     * 
     * @return int
     */
    public function deleteModal($id)
    {
        $this->modalDeleteVisible = true;

        return $this->idSelecting = $id;
    }

    /**
     * Delete applicant
     * 
     * @return void
     */
    public function rejectApplicant()
    {
        try {
            DB::transaction(function () {
                Applicant::find($this->idSelecting)->update(['state' => 'cancelled']);
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
            'title' => 'Rejected',
            'message' => 'Reject a applicant successfully.',
        ]);
        $this->emit('applicantUpdated');
    }

    public function render()
    {
        return view('livewire.candidates.reject');
    }
}
