<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $guarded = ['id'];
    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }
}
