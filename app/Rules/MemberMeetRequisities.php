<?php

namespace App\Rules;

use App\Models\Citizen;
use App\Models\Document;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\DocumentType;

class MemberMeetRequisities implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    private $type;
    public function __construct($type_id)
    {
        $this->type =DocumentType::find($type_id);

    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $member = Citizen::find($value);
        $type = $this->type;
        $requisites = $type->requisites->pluck('id');
        if($type != null)
        {
            $mainOwnedDocuments = Document::whereHas('unit_owner', function($query) use($value) {
                return $query->where('owner_id', $value);
            })->get()->pluck('type_id');
            $membersOwnedDocuments = Document::ownership($value)
            ->whereHas('type', function($query) {
                return $query->where('ownership_count', 'all');
            })->get()->pluck('type_id');

            $ownedDocuments = $mainOwnedDocuments->merge($membersOwnedDocuments);
            $requisitesFullfilled = $requisites->diff($ownedDocuments);
            if($requisitesFullfilled->isNotEmpty())
            {
                $fail("Members document requisites doesn't match");
            }
            return;
        }
        $fail("Type doesn't found");


    }
    private function CheckDocumentTypes()
    {

    }
}
