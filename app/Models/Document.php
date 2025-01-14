<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentType;
use App\Models\DocumentFolder;

class Document extends Model
{
    protected $guarded = ['id'];
    public function type()
    {
        return $this->belongsTo(DocumentType::class, 'type_id', 'id');
    }
    public function folders()
    {
        return $this->belongsToMany(DocumentFolder::class, 'document_folder_assignments');
    }
    public function unit_owner()
    {
        return $this->belongsTo(SocialUnit::class, 'unit_id', 'id');
    }
    // public function members()
    // {
    //     return $this->belongsToMany(Citizen::class, 'social_unit_citizens', 'unit_id', 'citizen_id', 'id', 'id');
    // }
    public function scopeOwnership($query, $citizenId)
    {
        return $query->whereHas('unit_owner.citizens', function($query) use($citizenId) {
            return $query->where('citizens.id', $citizenId);
        });
    }
}
