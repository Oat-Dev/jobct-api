<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewApplicantForCompany extends Mailable
{
    use Queueable, SerializesModels;
    public $job,
        $user, $company, $applicant;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, User $user, Company $company,$applicant)
    {
        $this->job = $job;
        $this->user = $user;
        $this->company = $company;
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->withSwiftMessage(function ($message) {
            $message->setPriority(\Swift_Message::PRIORITY_HIGH);
        })
            ->markdown('emails.applicant.jobs')
            ->subject('มีผู้สมัครงานใหม่')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'มีผู้สมัครงานใหม่เข้ามาให้ทางบริษัทได้พิจารณา โดยมีรายละเอียดดังต่อไปนี้ ',
                    '**อาชีพที่สมัคร:** ' . $this->user->name,
                    '**อาชีพที่สมัคร:** ' . $this->job->name,
                    '**เงินเดือนที่ต้องการ:** ' . $this->applicant[0]['salary'],
                    '**วันที่สะดวกสัมภาษณ์:** '.' วันที่ : ' . Carbon::parse($this->applicant[0]['request_interview_date'])->addyears(543)->locale('th')->isoFormat('LL') .' เวลา : '. Carbon::parse($this->applicant[0]['interview_time'])->locale('th')->isoFormat('LT').' น.',
                ],
                'outroLines' => [],
            ]);
    }
}
