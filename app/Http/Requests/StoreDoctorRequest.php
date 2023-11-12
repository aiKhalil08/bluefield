<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return user == admin
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'first_name'=> ['required', 'regex:/^[a-zA-Z-]*$/', 'max:20'],
            'last_name'=> ['required', 'regex:/^[a-zA-Z-]*$/', 'max:30'],
            'username'=> ['required', 'unique:App\Models\Doctor', 'max:20'],
            'password'=> ['confirmed'],
            'password_confirmation'=> ['required_with:password',],
            'passport'=> ['required', File::types(['jpeg', 'jpg'])->max(1024)],
            'email'=> ['exclude_unless:preference,email', 'required_if:preference,email', 'email'],
            'phone_number'=> ['exclude_unless:preference,sms', 'required_if:preference,sms', 'numeric'],
            'preference'=> ['required',]
        ];
    }

    public function attributes(): array {
        return [
            'phone' => 'phone number',
        ];
    }

    public function messages(): array {
        return [
            'required' => 'Please fill this field.',
            'passport.required' => 'Please chose a passport file.',
            'first_name.regex' => 'The :attribute field can only contain letters and dash (-).',
            'last_name.regex' => 'The :attribute field can only contain letters and dash (-).',
        ];
    }
}
