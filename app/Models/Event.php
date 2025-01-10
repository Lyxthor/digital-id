<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function requirements()
    {
        return $this->hasMany(EventDocumentRequirement::class, 'event_id' ,'id');
    }
}
