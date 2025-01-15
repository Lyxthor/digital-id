<?php

namespace App\Http\Requests\Citizen\Folder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use Illuminate\Support\Facades\Auth;

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
        return
        [
            "name"=>"nullable|unique:document_folders,name,NULL,id,owner_id,$citizenId",
            "document_ids"=>"array",
            "document_ids.*"=>"exists:documents,id"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        RequestHandler::redirect($validator->errors()->toArray());
    }
}
