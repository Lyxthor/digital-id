<?php

namespace App\Http\Requests\Dukcapil\Citizen;

use App\Rules\UniqueIfNotSame;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;

class UpdateCitizenRequest extends FormRequest
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
        $id = $this->route('id');
        return
        [
            "nik"=>["required", new UniqueIfNotSame('citizens', 'id', $id)],
            "name"=>"required",
            "gender"=>"required|in:m,f",
            "birth_date"=>"required|date|before:now",
            "birth_place"=>"required",
            "blood_type"=>"nullable|in:".implode(",", config('citizen.blood_types')),
            "job"=>"nullable",
            "pp_img"=>"nullable|file|mimes:jpg,png,jpeg",
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
