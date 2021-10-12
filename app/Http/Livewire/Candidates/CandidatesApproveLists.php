<?php

namespace App\Http\Livewire\Candidates;

use App\Mail\ApplicantInterviewStatusCancelled;
use App\Mail\ApplicantInterviewStatusFail;
use App\Mail\ApplicantInterviewStatusFinish;
use App\Models\Applicant;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CandidatesApproveLists extends Component
{
    protected $listeners = ['applicantUpdated' => '$refresh'];

    public function pass($id)
    {
        $applicant = Applicant::find($id);
        $company = Company::find($applicant->job->company_id);
        $applicant->state = 'finished';
        $applicant->save();
        Mail::to($applicant->user->email)->send(new ApplicantInterviewStatusFinish($applicant,$company));

        $this->emit('applicantUpdated');
    }

    public function notPass($id)
    {
        $applicant = Applicant::find($id);
        $company = Company::find($applicant->job->company_id);
        $applicant->state = 'cancelled';
        $applicant->save();
        Mail::to($applicant->user->email)->send(new ApplicantInterviewStatusFail($applicant,$company));

        $this->emit('applicantUpdated');
    }

    public function cancel($id)
    {
        $applicant = Applicant::find($id);
        $company = Company::find($applicant->job->company_id);
        $applicant->state = 'opened';
        $applicant->save();
        Mail::to($applicant->user->email)->send(new ApplicantInterviewStatusCancelled($applicant,$company));

        $this->emit('applicantUpdated');
    }

    public function render()
    {
        return view('livewire.candidates.candidates-approve-lists', [
            'applicants' => auth()->user()->company->applicants()->whereIn('state', ['interview'])->get(),
        ]);
    }
}
