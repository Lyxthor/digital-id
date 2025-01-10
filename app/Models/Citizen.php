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
    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }
}
