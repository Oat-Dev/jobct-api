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

class ApplicantInterviewStatusFinish extends Mailable
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
            ->subject('แจ้งผลการสัมภาษณ์')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'ทางบริษัท '.$this->company->name.' ขอแจ้งผลการสมัครงานของคุณ '.$this->applicant->user->name, 
                    'ทางเราพิจารณาแล้วว่า คุณสมบัติของคุณตรงกับสิ่งที่เราต้องการ',
                    'ในตำแหน่ง '.$this->applicant->job->name,
                    'โดยทางบริษัท จะติดต่อกลับไปหาคุณอีกครั้งหนึ่ง',
                    'ขอขอบคุณที่ใว้วางใจใช้บริการ JobCT ในการจัดหางานให้คุณ',
                    // '**Plan name:** ' . $this->order->product->plan_name,
                ],
                'outroLines' => [],
            ]);
    }
}