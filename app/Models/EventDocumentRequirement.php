<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDocumentRequirement extends Model
{
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'type_id', 'id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
