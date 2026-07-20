<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['note_id','file_path','uploaded_by'];

    public function note() { return $this->belongsTo(CounselingNote::class, 'note_id'); }
}
