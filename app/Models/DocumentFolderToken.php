<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFolderToken extends Model
{
    //
    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'folder_id', 'id');
    }
    public function authorized_users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
