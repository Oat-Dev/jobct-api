<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Company extends JsonResource
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
            'email' => $this->email,
            'tel' => $this->tel,
            'imageUrl' => Storage::disk('do_spaces')->url($this->profile_photo_path),
            // Address
            'address' => $this->address,
            'province' => $this->province,
            'district' => $this->district,
            'sub_district' => $this->sub_district,
        ];
    }
}
