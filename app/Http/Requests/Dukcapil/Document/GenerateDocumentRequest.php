<?php

namespace App\Http\Requests\Dukcapil\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\CheckForDuplicatedDocument;
use App\Helpers\RequestHandler;
use App\Models\Citizen;
use App\Models\DocumentType;
use App\Rules\CheckDocumentMembership;

class GenerateDocumentRequest extends FormRequest
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
            "memberships"=>["required", "array", "min:1", new CheckDocumentMembership($this->type_id, $this->owner_id)],
            "memberships.*.id"=>"required|exists:citizens,id",
            "memberships.*.role"=>"required",
            "type_id"=>["required", "exists:document_types,id", new CheckForDuplicatedDocument($this->owner_id)]
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();
        $memberships = $validatedData['memberships'];
        $ids = $this->getEl($memberships, 'id');
        $roles = $this->getEl($memberships, 'role');
        $members = Citizen::whereIn('id', $ids)->get()->toArray();
        $validatedData['members'] = array_map(function ($subArray1, $subArray2) {
            $subArray2['role'] = $subArray1;
            return $subArray2;
        }, $roles, $members);
        $validatedData['owner'] = Citizen::find($this->owner_id);
        $validatedData['type'] = DocumentType::find($this->type_id);
        $validatedData['additional'] = [];
        return $validatedData;
        // $validatedData['citizen'] = Citizen::find($this->owner_id);
        // return $validatedData;
    }
    private function getEl($array, $key)
    {
        $ids = [];
        foreach(array_values($array) as $arr)
        {
            array_push($ids, $arr[$key]);
        }
        return $ids;
    }

    public function failedValidation(Validator $validator)
    {
        RequestHandler::redirect($validator->errors()->toArray());
    }
}
