<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'email', 
        'phone_number', 
        'website', 
        'linkedin_link', 
        'github_link', 
        'twitter'
    ];

public function user()
{
    return $this->belongsTo(User::class);
}
}
