<?php

namespace App\Http\Requests\Citizen\Document;

use App\Rules\CheckForDuplicatedDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use App\Models\Citizen;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Auth;

class UpdateDocumentRequest extends FormRequest
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
            "type_id"=>["required", "exists:document_types,id"],
            'file'=>["nullable","image","mimes:png,jpg,jpeg"]
        ];
    }
    public function withValidator(Validator $validator)
    {

        $validator->after(function($validator)  {
            $documentId = $this->route('id');
            if($validator->errors()->isEmpty())
            {
                $document = Document::find($documentId);
                if($document->type->category == 'official')
                {
                    $validator->errors()->add('type_id', 'Cant edit official document');
                }
                $typeId = (int)$this->type_id;
                if($document->type_id != $typeId)
                {
                    $rule = new CheckForDuplicatedDocument(Auth::user()->userable_id);
                    $rule->validate('type_id', $this->type_id ?? null, function($message) use($validator) {
                        $validator->errors()->add('type_id', $message);
                    });
                }
            }
        });

        if($validator->fails())
        {
            $this->failedValidation($validator);
        }
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


