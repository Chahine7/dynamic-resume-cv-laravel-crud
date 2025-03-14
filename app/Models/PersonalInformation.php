<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'profile_title', 
        'about_me', 
        'image_path'
    ];
public function user()
{
    return $this->belongsTo(User::class);
}
    
}
