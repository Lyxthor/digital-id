<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id'];
    public function author()
    {
        return $this->belongsTo(Citizen::class, 'author_id', 'id');
    }
    public function requirements()
    {
        return $this->belongsToMany(DocumentType::class, 'event_document_requirements', 'event_id', 'type_id','id','id');
    }
    public function reviewers()
    {
        return $this->belongsToMany(Citizen::class, 'event_reviewers', 'event_id', 'reviewer_id', 'id', 'id');
    }
    public function document_tokens()
    {
        return $this->belongsToMany(DocumentFolderToken::class, 'token_authorized_events',  'event_id', 'token_id', 'id', 'id');
    }
}
