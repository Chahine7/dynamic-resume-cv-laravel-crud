<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'job_title', 
        'organization', 
        'job_start_date', 
        'job_end_date', 
        'job_description'
    ];

public function user()
{
    return $this->belongsTo(User::class);
}
}
