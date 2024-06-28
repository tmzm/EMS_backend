<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        $array = [
            'name' => 'required|min:5|max:50',
            'password' => 'required|min:8|max:50',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required|unique:users,phone',
            'role' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png'
        ];

        if($request->role == 'trademark_owner') $array['trademark_name'] = 'required|min:5|max:50';

        return $array;
    }
}
