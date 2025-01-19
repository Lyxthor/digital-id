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
            "name"=>"required",
            "gender"=>"required|in:m,f",
            "birth_date"=>"required|date|before:now",
            "birth_place"=>"required",
            "blood_type"=>"nullable|in:".implode(",", config('citizen.blood_types')),
            "job"=>"nullable",
            "pp_img"=>"required|file|mimes:jpg,png,jpeg",
            "address"=>"required",
            "village"=>"required",
            "district"=>"required",
            "regency"=>"required",
            "province"=>"required",
            "religion"=>"required",
            "education"=>"required",
            "marriage_status"=>"nullable|enum:belum kawin,kawin",
        ];
    }
    public function failedValidation(Validator $validator)
    {

        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
