<?php

namespace App\Http\Requests;

use App\Models\PlayerTeam;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PlayerTeamRequest extends FormRequest
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
                        'player_id'     => 'required|exists:players,id',
                        'team_id'     => 'required|exists:teams,id',
                    ];

                    return $rules;
                }
            case 'PUT':
                {
                    $rules = [
                    ];

                    return $rules;
                }
            case 'PATCH':
            default:
                break;
        }
    }


    public function withValidator(Validator $validator): void
    {

        $validator->after(function (Validator $validator) {

            $playerTeam = PlayerTeam::where('player_id', $validator->validated()['player_id'])
                                    ->where('team_id', $validator->validated()['team_id'])
                                    ->exists();
            if($playerTeam){
                $validator->errors()->add('player_team', 'already exists!');
            }

        });
    }
}
