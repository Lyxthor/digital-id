<?php

namespace App\Http\Requests\Dukcapil\Document;

use App\Rules\CheckForDuplicatedDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use App\Models\Citizen;
use App\Models\DocumentType;

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
            "owner_id"=>"required|exists:citizens,id",
            "memberships"=>"required|array|min:1",
            "memberships.*.id"=>"required|exists:citizens,id",
            "memberships.*.role"=>"required",
            "type_id"=>["required", "exists:document_types,id", new CheckForDuplicatedDocument($this->owner_id)],
            'filename'=>["required"]
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();
        $type = DocumentType::select(['name'])->find($this->type_id);
        $validatedData['name'] = $type->name;
        $validatedData['owner'] = Citizen::find($this->owner_id);
        return $validatedData;
    }
    public function failedValidation(Validator $validator)
    {

        RequestHandler::redirect($validator->errors()->toArray());
    }
}
