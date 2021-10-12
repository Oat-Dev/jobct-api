<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterCompanyRequest extends FormRequest
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
            'email' => 'required|unique:users,email|email',
            'password' => 'required|string|confirmed|min:6',
            'profile_photo_path' => 'nullable|image|max:2048|mimes:jpeg,jpg,png',
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
            'email.required'  => 'A email is required',
            'password.required'  => 'A password is required',
            'type.required'  => 'A type is required',
            'tel' => 'A Tel is required',
            'address' => 'A address is required',
            'area_province_id' => 'A area_province_id is required',
            'area_district_id' => 'A area_district_id is required',
            'area_sub_district_id' => 'A area_sub_district_id is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'type' => 'Type',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     $json = [
    //         'status' => 'register_error',
    //         'errors' => [
    //             'name.required'    => 'ไม่ได้กรอกชื่อ',
    //             'email.required'  => 'ไม่ได้กรอกอีเมล์',
    //             'password.required'  => 'ไม่ได้กรอกพาสเวิด',
    //             'type.required'  => 'ไม่ได้กรอกไทป์',
    //         ]
    //     ];
    //     $response = new JsonResponse($json, 422);
    //     throw (new ValidationException($validator, $response))->status(422);
    // }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
