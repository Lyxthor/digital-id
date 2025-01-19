<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;

class CitizenDataClaimRequest extends FormRequest
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
        return
        [
            "username"=>"required|min:6|max:25|unique:users",
            "password"=>"required|min:6",
            "email"=>"required|email|unique:users,email",
            "mobile"=>"required|unique:users,mobile",
            "nik"=>"required|exists:citizens,nik",
            "request_password"=>"required|min:6"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
