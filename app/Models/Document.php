<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentType;
use App\Models\DocumentFolder;

class Document extends Model
{

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'type_id', 'id');
    }
    public function folders()
    {
        return $this->belongsToMany(DocumentFolder::class, 'document_folder_assignments');
    }
    public function owner()
    {
        return $this->belongsTo(Citizen::class, 'owner_id', 'id');
    }
}
