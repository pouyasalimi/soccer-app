<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest {
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
        switch ( $this->method() ) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    $rules = [
                        'name'     => 'required|min:3',
                        'email'    => 'required|email|unique:users',
                        'password' => 'required|min:3|confirmed',
                        'picture'  => 'nullable',
                    ];

                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        'name'     => 'required',
                        'email'    => 'required|email|unique:users,email,' . $this->input( 'user_id' ),
                        'password' => 'sometimes|min:3|confirmed',
                        'picture'  => 'nullable',
                    ];

                    return $rules;
                }
            case 'PATCH':
            default:
                break;
        }
    }
}
