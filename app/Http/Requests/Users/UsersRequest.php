<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'roles' => 'required',

        ];
        $id = $this->route('id');

        return [
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'patronymic' => 'max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|min:10|max:13',
            'roles' => $rules,
        ];
    }
}
