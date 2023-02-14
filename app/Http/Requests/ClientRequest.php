<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'shop_name' => 'required',
        ];


        if($this->client_id)
        {
            $rules += [
                'email' => 'required|email|unique:users,email,'.$this->client_id,
                'confirm_password' => 'same:password',
            ];
        }
        else
        {
            $rules += [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ];
        }

        return $rules;
    }
}
