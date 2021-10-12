<?php

namespace App\Http\Livewire;

use App\Models\AreaDistrict;
use App\Models\AreaProvince;
use App\Models\AreaSubDistrict;
use Livewire\Component;

class Stateprovince extends Component
{
    public $provinces;
    public $districts;
    public $subdistricts;

    public $selectedStateDistrict = NULL;
    public $selectedStateSubDistrict = NULL;

    public function mount()
    {
        $this->provinces = AreaProvince::all();
        $this->districts = collect();
        $this->subdistricts = collect();
    }

    // public function updatedSelectedStateDistrict($selectedState)
    // {
    //     if (!is_null($selectedState)) {
    //         $this->districts = AreaDistrict::where('area_province_id', $selectedState)->get();
    //     }
    // }

    public function render()
    {
        return view('livewire.stateprovince');
    }

    public function updatedSelectedStateDistrict($state)
    {
        if (!is_null($state)) {
            $this->districts = AreaDistrict::where('area_province_id', $state)->get();
        }
    }

    public function updatedSelectedStateSubDistrict($state)
    {
        if (!is_null($state)) {
            $this->subdistricts = AreaSubDistrict::where('area_district_id', $state)->get();
        }
    }
}
