<?php

namespace App\Http\Requests\Citizen\Folder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use Illuminate\Support\Facades\Auth;
use App\Rules\UniqueIfNotSame;

class UpdateFolderRequest extends FormRequest
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
        $citizenId = Auth::user()->userable->id;
        $folderId = $this->route('id');
        return
        [
            "name"=>"nullable|unique:document_folders,name,NULL,id,owner_id,$citizenId",
            "name"=>["nullable", new UniqueIfNotSame('document_folders', 'name', $folderId)],
            "document_ids"=>"array",
            "document_ids.*"=>"exists:documents,id"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
