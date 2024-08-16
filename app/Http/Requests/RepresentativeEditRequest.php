<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepresentativeEditRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "name" => "min:5|max:50",
            "image" => "",
            "email" => "email|unique:users,email",
            "phone" => "",
            "visa_state" => "enum:accepted,pending,denied",
            "passport_number" => "unique:representative,passport_number"
        ];
    }
}
