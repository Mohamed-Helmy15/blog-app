<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public function blog(){
    return $this->belongsTo(Blog::class);
    }

    protected $fillable = [
        'blog_id',
        'section_title',
        'image',
        'content',
    ];
}
