<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Citizen extends Model
{
    protected $guarded = ['id'];
    public function user() : MorphOne
    {
        return $this->morphOne(User::class, 'userable', 'userable_type', 'userable_id');
    }
    public function social_units()
    {
        return $this->belongsToMany(SocialUnit::class, 'social_unit_citizens', 'citizen_id', 'unit_id', 'id', 'id');
    }
    public function scopeDocuments($query, $id)
    {
        return $query->with(['social_units.document'])->where('id', $id);
    }
    public function folders()
    {
        return $this->hasMany(DocumentFolder::class, 'owner_id', 'id');
    }
    public function document_tokens()
    {
        return $this->belongsToMany(Citizen::class, 'token_authorized_citizens',  'citizen_id', 'token_id', 'id', 'id');
    }
}
