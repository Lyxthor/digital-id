<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUnit extends Model
{
    //
    protected $guarded = ['id'];
    public function citizens()
    {
        return $this->belongsToMany(Citizen::class, 'social_unit_citizens', 'unit_id', 'citizen_id');
    }
    public function document()
    {
        return $this->hasOne(Document::class, 'unit_id', 'id');
    }
}
