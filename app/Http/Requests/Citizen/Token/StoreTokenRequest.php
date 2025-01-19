<?php

namespace App\Http\Requests\Citizen\Token;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\RequestHandler;
use Illuminate\Support\Str;

class StoreTokenRequest extends FormRequest
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
            'name'=>'nullable',
            'folder_id'=>'required|exists:document_folders,id',
            'expires_at'=>'nullable|date',
            'accessibility'=>'required|in:public,restricted',
            'authorized_citizens'=>'required_if:accessibility,restricted|array|min:1',
            'authorized_citizens.*'=>'exists:citizens,id'
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validData = parent::validated();
        $validData['name'] = $this->name ?? Str::random(8);
        $validData['authorized_citizens'] = $validData['authorized_citizens'] ?? [];
        return $validData;
    }
    public function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
