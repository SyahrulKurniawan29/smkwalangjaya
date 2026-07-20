<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounselingSession extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','counselor_id','scheduled_at','session_type','status','privacy_level'];

    public function notes() { return $this->hasMany(CounselingNote::class, 'session_id'); }
}
