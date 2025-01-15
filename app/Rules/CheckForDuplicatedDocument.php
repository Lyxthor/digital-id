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
        $documents = Document::with('unit_owner')
        ->ownership($citizen->id)
        ->where('type_id', $value)
        ->get();
        $type = DocumentType::find($value);
        $ownershipCount = $type->ownership_count;
        if($ownershipCount == "mono")
        {
            if($documents->isNotEmpty())
            {
                $ownershipLimit = $this->CheckOwnershipLimit($documents, $citizen);
                if($ownershipLimit)
                {
                    $fail("Citizen $citizen->nik can only have one document of $type->name type");
                    return;
                }
                // TAMBAHKAN checkOwnerShip document, jika citizen adalah pemilik dari dokumen ini dan
                // document hanya mengizinkan satu buah document untuk owner maka gagalkan validasi
            }

            // buat juga field baru untuk jumlah ownership document
        }
    }
    public function CheckOwnershipLimit($documents, $citizen)
    {
        foreach($documents as $doc)
        {
            $isForMain = $doc->type->member_ownership == "main";
            $isForAll = $doc->type->member_ownership == "all";
            if($isForAll)
            {
                return true;
            }
            if($isForMain)
            {
                if($doc->unit_owner->owner_id == $citizen->id)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
