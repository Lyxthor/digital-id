<?php

namespace App\Http\Requests\Citizen\Event;

use App\Helpers\RequestHandler;
use App\Models\Document;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class SubmitTokenToEventRequest extends FormRequest
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
            'document_ids'=>'required|array|min:1',
            'document_ids.*'=>'exists:documents,id'
        ];
    }
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $eventId = $this->route('id');
            $event = Event::find($eventId);
            $citizen = Auth::user()->userable;
            $document_ids = $this->document_ids ?? [];
            $documents = Document::whereIn('id', $document_ids)->get();

            $col1 = $event->requirements->pluck('id')->toArray();
            $col2 = $documents->pluck('type_id')->toArray();

            if(count(array_diff($col1, $col2)) > 0)
            {
                $validator->errors()->add('document_ids', 'sent documents doesn`t fullfill event requirements');
            }

        });

        if($validator->fails())
        {
            $this->failedValidation($validator);
        }
    }
    protected function failedValidation(Validator $validator)
    {
        return RequestHandler::redirect($validator->errors()->toArray());
    }
}
