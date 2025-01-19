<?php

namespace App\Http\Requests\Citizen\Document;

use App\Rules\CheckForDuplicatedDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use App\Models\Citizen;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Auth;

class StoreDocumentRequest extends FormRequest
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
            "name"=>["nullable"],
            "type_id"=>["required", "exists:document_types,id", new CheckForDuplicatedDocument(Auth::user()->userable_id)],
            'file'=>["required","image","mimes:png,jpg,jpeg"]
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();
        $type = DocumentType::select(['name'])->find($this->type_id);
        $validatedData['name'] = $validatedData['name'] ?? $type->name;
        return $validatedData;
    }
    public function failedValidation(Validator $validator)
    {

        return RequestHandler::redirect($validator->errors()->toArray());
    }
}


