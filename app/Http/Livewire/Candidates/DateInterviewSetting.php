<?php

namespace App\Http\Livewire\Candidates;

use App\Mail\ApplicantInterviewStatus;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class DateInterviewSetting extends Component
{
    public $applicant;

    protected $rules = [
        'applicant.interview_date' => 'string|date_format:Y-m-d',
        'applicant.interview_time' => 'string|date_format:H:i:s',
    ];

    public function save()
    {
        try {
            $applicant = $this->applicant;
            $company = Company::find($applicant->job->company_id);
            $this->applicant->state = 'interview';
            $this->applicant->save();
            Mail::to($applicant->user->email)->send(new ApplicantInterviewStatus($applicant, $company));
        } catch (Exception $e) {
            return $this->emit('toastrAdded', [
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ]);
        }

        $this->emit('toastrAdded', [
            'type' => 'success',
            'title' => 'Updated',
            'message' => 'Update applicant was successfully',
        ]);
        return redirect()->to('/candidate/interview/approve');
    }

    public function render()
    {
        return view('livewire.candidates.date-interview-setting');
    }
}
