<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [];
        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    $rules = [
                        'email'    => 'required|email|exists:users,email',
                        'password' => 'required|min:3',
                    ];

                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        'name'     => 'required',
                        'email'    => 'required|email|unique:users',
                        'password' => 'required|min:3|confirmed',
                    ];

                    return $rules;
                }
            case 'PATCH':
            default:
                break;
        }
    }
}
