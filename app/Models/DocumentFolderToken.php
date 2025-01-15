<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFolderToken extends Model
{
    //
    protected $guarded = ['id'];
    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'folder_id', 'id');
    }
    public function authorized_citizens()
    {
        return $this->belongsToMany(Citizen::class, 'token_authorized_citizens', 'token_id', 'citizen_id', 'id', 'id');
    }
}
