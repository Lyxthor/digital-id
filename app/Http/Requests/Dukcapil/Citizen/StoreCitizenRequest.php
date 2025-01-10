<?php

namespace App\Http\Requests\Dukcapil\Citizen;

use App\Helpers\RequestHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCitizenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // add middleware here
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
            "nik"=>"required|unique:citizens,nik",
            "no_kk"=>"required",
            "name"=>"required",
            "gender"=>"required|in:m,f",
            "birth_date"=>"required|date|before:now",
            "birth_place"=>"required",
            "blood_type"=>"nullable|in:".implode(",", config('citizen.blood_types')),
            "job"=>"nullable",
            "pp_img"=>"required|file|mimes:jpg,png,jpeg",
            "current_address"=>"required"
        ];
    }
    public function failedValidation(Validator $validator)
    {

        RequestHandler::redirect($validator->errors()->toArray());
    }
}
