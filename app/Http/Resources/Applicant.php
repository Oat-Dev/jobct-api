<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Applicant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'job' => $this->job,
            'salary' => $this->salary,
            'state' => $this->state,
            'request_interview_date' => $this->request_interview_date,
            'request_interview_time' => $this->request_interview_time,
            'interview_date' => $this->interview_date,
            'interview_time' => $this->interview_time,
        ];
    }
}
