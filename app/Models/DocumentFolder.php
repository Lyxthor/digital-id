<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFolder extends Model
{
    protected $fillable = [
        'name',
        'category',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Citizen::class, 'owner_id');
    }
}
