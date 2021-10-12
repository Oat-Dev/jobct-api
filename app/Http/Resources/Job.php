<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Job extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'content' => $this->trixRichText[0]->content,
            'amount' => $this->amount,
            'salary' => $this->salary,
            'optional_work_from_home' => $this->optional_work_from_home,
            'company' => [
                "company_id" => $this->company->id,
                "name" => $this->company->name,
                "email" => $this->company->email,
                "tel" => $this->company->tel,
                "profile_photo_path" => Storage::disk('do_spaces')->url($this->company->profile_photo_path),
                "address" => $this->company->address,
                "area_province_id" => $this->company->area_province_id,
                "area_district_id" => $this->company->area_district_id,
                "area_sub_district_id" => $this->company->area_sub_district_id,
                "user_id" => $this->company->user_id,
                "created_at" => $this->company->created_at,
                "updated_at" => $this->company->updated_at,
            ],
        ];
    }
}
