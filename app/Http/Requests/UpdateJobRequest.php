<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateJobRequest extends FormRequest
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
            'name' => 'string',
            'description' => 'string',
            'job-trixFields' => 'nullable|array',
            'job-trixFields.content' => 'nullable|string',
            'attachment-job-trixFields' => 'nullable|array',
            'attachment-job-trixFields.content.*' => 'nullable|file',
            'amount' => 'numeric',
            'salary_min' => 'string',
            'salary_max' => 'string',
            'optional_work_from_home' => 'required|string',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     $json = [
    //         'status' => 'job_update_error',
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
