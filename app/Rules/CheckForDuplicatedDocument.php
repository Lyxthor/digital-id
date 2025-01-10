<?php

namespace App\Rules;

use App\Models\Citizen;
use App\Models\DocumentType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckForDuplicatedDocument implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $citizen;
    public function __construct($citizenId)
    {
        $this->citizen = Citizen::find($citizenId);
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $citizen = $this->citizen;
        if($citizen == null) return;
        $documents = $citizen->documents;
        if($documents == null) return;
        $type = DocumentType::find($value);
        $multiability = $type->multiability;
        if($multiability == "singular")
        {
            $docAlreadyExist = $documents->where('type_id', $value)->isNotEmpty();
            if($docAlreadyExist)
            {
                $fail("Document $type->name should be just one document");
                return;
            }
        }
    }
}
