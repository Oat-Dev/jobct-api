<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreJobRequest extends FormRequest
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
            'name' => 'required|string|unique:jobs,name',
            'description' => 'required|string',
            'job-trixFields' => 'required|array',
            'job-trixFields.content' => 'required|string',
            'attachment-job-trixFields' => 'nullable|array',
            'attachment-job-trixFields.content.*' => 'nullable|file',
            'amount' => 'required|numeric',
            'salary' => 'required|string',    
            'optional_work_from_home' => 'required|boolean',
            // 'company_id' => 'required|numeric',
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
            'amount.required'  => 'A amount is required',
            'salary.required'  => 'A salary is required',    
            'optional_work_from_home.required'  => 'A optional_work_from_home is required',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     $json = [
    //         'status' => 'job_error',
    //         'errors' => 'job name duplicate'
    //     ];
    //     $response = new JsonResponse($json, 400);
    //     throw (new ValidationException($validator, $response))->status(400);
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
