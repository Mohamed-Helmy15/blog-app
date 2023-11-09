<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function blog() {
        return $this->hasMany(Blog::class);
    }

    protected $fillable = [
        'user_id',
    ];
    protected $with = [
        'user',
    ];
}
