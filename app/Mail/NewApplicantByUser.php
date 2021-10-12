<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewApplicantByUser extends Mailable
{
    use Queueable, SerializesModels;
    public $job,
        $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, User $user, Company $company)
    {
        $this->job = $job;
        $this->user = $user;
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
            ->subject('ขอบคุณที่สนใจสมัครงานกับเรา')
            ->with([
                'level' => 'success',
                'introLines' => [
                    'ทางบริษัท '. $this->company->name. ' ได้รับการสมัครงานของคุณ ' .$this->user->name. ' แล้ว ทางเราจะพิจารณาและแจ้งผลให้คุณทราบอีกครั้ง.',
                    '**อาชีพที่สมัคร:** ' . $this->job->name,
                    // '**Company name:** ' . $this->company->name,
                    // '**Plan name:** ' . $this->order->product->plan_name,
                ],
                'outroLines' => [],
            ]);
    }
}
