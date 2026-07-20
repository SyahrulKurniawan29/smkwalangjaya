<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis','name','classroom_id','dob','parent_contact'
    ];

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
}
