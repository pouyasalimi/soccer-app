<?php

namespace App\Http\Requests;

use App\Http\Response\Json;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class FormRequest extends LaravelFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();


    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new Json();
        throw new HttpResponseException($response->failureStatus('', $validator->errors(), 422));
    }
}
