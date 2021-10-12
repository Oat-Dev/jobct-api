<?php

namespace App\Mail;

use App\Models\Applicant;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantInterviewStatus extends Mailable
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
            ->subject('แจ้งผลการสมัครงาน/การนัดสัมภาษณ์')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'ทางบริษัท '.$this->company->name. ' ขอแจ้งผลการสมัครงานของคุณ '.$this->applicant->user->name. ' ทางเราพิจารณาแล้วว่าคุณสมบัติของคุณตรงกับสิ่งที่เราต้องการ',
                    'ทางบริษัทจะมีการนัดหมายเพื่อสัมภาษณ์ โดยมีรายละเอียดดังต่อไปนี้',
                    '**ตำแหน่ง** ' . $this->applicant->job->name,
                    '**วันที่นัดสัมภาษณ์** ' . ' วันที่ '. Carbon::parse($this->applicant->interview_date)->addyears(543)->locale('th')->isoFormat('LL'),
                    '**เวลา** '. Carbon::parse($this->applicant->interview_time)->locale('th')->isoFormat('LT').' น.',
                    '**สถานที่ตั้ง** '. $this->company->address. ', '.$this->company->sub_district->name_th. ', '.$this->company->district->name_th. ', '.$this->company->province->name_th. ', '.$this->company->sub_district->zip_code,
                    'ขอบคุณที่ใช้บริการสมัครงานกับ JobCT',
                    // '**Company name:** ' . $this->company->name,
                    // '**Plan name:** ' . $this->order->product->plan_name,
                ],
                'outroLines' => [],
            ]);
    }
}
