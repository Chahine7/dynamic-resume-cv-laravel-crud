<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'project_title', 
        'project_description'
    ];

public function user()
{
    return $this->belongsTo(User::class);
}
}
