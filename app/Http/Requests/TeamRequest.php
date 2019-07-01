<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
                    ];

                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                        'name'     => 'required|unique:teams,name,' . $this->route('id' ),
                    ];

                    return $rules;
                }
            case 'PATCH':
            default:
                break;
        }
    }
}
