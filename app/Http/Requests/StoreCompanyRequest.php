<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'email' => 'required|unique:companies|email',
            'tel' => 'required|string',
            'address' => 'required|string',
            'area_province_id' => 'required|numeric',
            'area_district_id' => 'required|numeric',
            'area_sub_district_id' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => 'A name is required',
            'description.required'  => 'A description is required',
            'email.required'  => 'A email is required',
            'tel.required'  => 'A telephone is required',
            'address.required'  => 'A address is required',
            'area_province_id.required'  => 'A area_province_id is required',
            'area_district_id.required'  => 'A area_district_id is required',
            'area_sub_district_id.required'  => 'A area_sub_district_id is required',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     $json = [
    //         'status' => 'company_error',
    //         'errors' => 'company duplicate'
    //     ];
    //     $response = new JsonResponse($json, 400);
    //     throw (new ValidationException($validator, $response))->status(400);
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
