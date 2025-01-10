<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $guarded = ['id'];
    public function documents()
    {
        return $this->hasMany(Document::class, 'type_id', 'id');
    }
    public function event_document_requirements()
    {
        return $this->hasMany(EventDocumentRequirement::class, 'type_id', 'id');
    }
}
