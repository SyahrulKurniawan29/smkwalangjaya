<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounselingNote extends Model
{
    use HasFactory;

    protected $fillable = ['session_id','note_text','created_by','confidential'];

    public function session() { return $this->belongsTo(CounselingSession::class, 'session_id'); }
}
