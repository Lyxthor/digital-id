<?php

namespace App\Rules;

use App\Models\DocumentType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDocumentMembership implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $type;
    private $owner_id;
    public function __construct($type_id, $owner_id)
    {
        $this->type = DocumentType::find($type_id);
        $this->owner_id = $owner_id;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type = $this->type;
        $owner_id = $this->owner_id;
        if($type==null) return;
        $members = $value;
        if($type->membership_count == "mono")
        {
            if(count($members) != 1)
            {
                $fail("This type of document shouldn't have more than one member");
                return;
            }
            if(array_values($members)[0]['id'] != $owner_id)
            {
                $fail("Owner id and member id should be same for mono type document");
                return;
            }
            return;
        }
        if($type->membership_count == "multi")
        {
            foreach($members as $m)
            {
                if($m['id'] == $owner_id)
                {
                    return;
                }
            }
            $fail("Owner's membership doesn't exists in members list");
        }
    }
}
