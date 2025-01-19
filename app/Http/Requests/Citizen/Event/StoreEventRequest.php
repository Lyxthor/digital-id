<?php

namespace App\Http\Requests\Citizen\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use Illuminate\Support\Facades\Auth;

class StoreEventRequest extends FormRequest
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
            "title"=>"required",
            "desc"=>"required",
            "banner_img"=>"nullable|image|mimes:png,jpg,jpeg,webp",
            "submit_deadline"=>"required|date|date_format:Y-m-d\TH:i|after:now",
            "access_expires_at"=>"required|date|date_format:Y-m-d\TH:i|after:submit_deadline",
            "document_requirements"=>"required|array|min:1",
            "document_requirements.*"=>"exists:document_types,id",
            "reviewers"=>"array",
            "reviewers.*"=>"exists:citizens,id"
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validData = parent::validated();
        $validData['author_id'] = Auth::user()->userable->id;
        return $validData;
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
