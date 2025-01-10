<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueIfNotSame implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $table, $col, $id;
    public function __construct($table, $col, $id)
    {
        $this->table=$table;
        $this->col=$col;
        $this->id = $id;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $table = $this->table;
        $col = $this->col;
        $id = $this->id;
        $data= DB::table($table)->select($col)->find($id);

        if($data == null)
        {
            $fail("Citizen not found");
            return;
        }
        $exists =  $data->{$col} == $value;
        if(!$exists)
        {
            $duplicate = DB::table($table)->select($col)->where($col, $value);
            if($duplicate->count() > 0)
            {
                $fail("$col should be unique");
            }
        }
    }
}
