<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateCompanyRequest extends FormRequest
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

    // public function failedValidation(Validator $validator)
    // {
    //     $json = [
    //         'status' => 'company_update_error',
    //         'errors' => 'more data'
    //     ];
    //     $response = new JsonResponse($json, 400);
    //     throw (new ValidationException($validator, $response))->status(400);
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
