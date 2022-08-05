<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            'name' => 'required|string',
            'email' => "required|unique:users,email",
            // 'password' => "required|min:8",
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $id = $this->user->id;

            $rules['email'] = [
                'required',
                "unique:users,email,{$id},id",
            ];
        }

        return $rules;
    }
}
