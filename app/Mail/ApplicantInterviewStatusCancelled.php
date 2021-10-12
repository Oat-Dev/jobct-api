<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use App\Models\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantInterviewStatusCancelled extends Mailable
{
    use Queueable, SerializesModels;

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
            ->subject('แจ้งผลการยกเลิกการสัมภาษณ์')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'ทางบริษัท '.$this->company->name.' ได้ทำการยกเลิกการสัมภาษณ์งานของคุณ '.$this->applicant->user->name,
                    'ในตำแหน่ง '.$this->applicant->job->name, 
                    'โดยทางเราจะพิจารณาในการเรียกสัมภาษณ์ใหม่อีกครั้ง',
                    'ขอบคุณที่ใช้บริการสมัครงานกับ JobCT',
                    // '**Plan name:** ' . $this->order->product->plan_name,
                ],
                'outroLines' => [],
            ]);
    }
}