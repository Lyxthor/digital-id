<?php

namespace App\Http\Requests\Dukcapil\DocumentType;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\RequestHandler;
use App\Rules\UniqueIfNotSame;
use Illuminate\Contracts\Validation\Validator;

class UpdateDocumentTypeRequest extends FormRequest
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
            "name"=>["required", new UniqueIfNotSame('document_types', 'name', $id)],
            "category"=>"required|in:official,custom",
            "ownership_count"=>"required|in:mono,multi",
            "membership_count"=>"required|in:mono,multi",
            "member_ownership"=>"required|in:main,all",
            "requisites"=>"nullable|array",
            "requisites.*"=>"exists:document_types,id|not_in:$id"
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validData = parent::validated();
        $validData['requisites'] = $validData['requisites'] ?? [];
        return $validData;
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
