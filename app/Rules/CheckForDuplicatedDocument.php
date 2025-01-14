<?php

namespace App\Rules;

use App\Models\Citizen;
use App\Models\DocumentType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Document;

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
        $documents = Document::ownership($citizen->id);
        $type = DocumentType::find($value);
        $multiability = $type->multiability;
        if($multiability == "mono")
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
