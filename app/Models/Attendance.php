<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','classroom_id','date','status','note','recorded_by'];

    public function student() { return $this->belongsTo(Student::class); }
}
