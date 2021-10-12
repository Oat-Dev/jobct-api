<div>
    <div class="mt-4">
        <select class="block appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
        wire:model="selectedStateDistrict" name="area_province_id">
            <option value="" selected>Choose province</option>
            @foreach($provinces as $province)
            <option value="{{ $province->id }}">{{ $province->name_th }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <i class="fas fa-angle-down"></i>
        </div>
    </div>

    @if (!is_null($selectedStateDistrict))
    <div class="mt-4">
        <select class="block appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
        wire:model="selectedStateSubDistrict"  name="area_district_id">
            <option value="" selected>Choose district</option>
            @foreach($districts as $district)
            <option value="{{ $district->id }}">{{ $district->name_th }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <i class="fas fa-angle-down"></i>
        </div>
    </div>
    @endif

    @if (!is_null($selectedStateSubDistrict))
    <div class="mt-4">
        <select class="block appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
         name="area_sub_district_id">
            <option value="" selected>Choose subdistrict</option>
            @foreach($subdistricts as $subdistrict)
            <option value="{{ $subdistrict->id }}">{{ $subdistrict->name_th }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <i class="fas fa-angle-down"></i>
        </div>
    </div>
    @endif
</div>