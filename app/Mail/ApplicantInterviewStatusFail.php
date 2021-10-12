<?php

namespace App\Mail;

use App\Models\Applicant;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantInterviewStatusFail extends Mailable
{
    use Queueable, SerializesModels;
    public $job,
        $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct(Applicant $applicant)
    public function __construct(Applicant $applicant, Company $company)
    {
        $this->applicant = $applicant;
        $this->company = $company;
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
            ->subject('แจ้งผลการสมัครงาน')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'ทางบริษัท '.$this->company->name.' ขอแจ้งผลการสมัครงานของคุณ '.$this->applicant->user->name ,
                    'ทางเราพิจารณาแล้วว่า คุณสมบัติของคุณไม่ตรงกับสิ่งที่เราต้องการ',
                    'ในตำแหน่ง '.$this->applicant->job->name,
                    'ขอบคุณอีกครั้งที่สนใจร่วมสมัครงาน',
                    // '**Company name:** ' . $this->company->name,
                    // '**Plan name:** ' . $this->order->product->plan_name,
                ],
                'outroLines' => [],
            ]);
    }
}
