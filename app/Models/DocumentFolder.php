<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFolder extends Model
{
    //
    protected $guarded = ['id'];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_folder_assignments', 'folder_id', 'document_id', 'id', 'id');
    }
}
