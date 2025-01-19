<?php

namespace App\Http\Requests\Citizen\Folder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use Illuminate\Support\Facades\Auth;

class StoreFolderRequest extends FormRequest
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
            "name"=>"required|unique:document_folders,name,NULL,id,owner_id,$citizenId",
            "category"=>"required|in:onDemand,preMade"
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validData = parent::validated();
        $validData['owner_id'] = Auth::user()->userable->id;
        return $validData;
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
