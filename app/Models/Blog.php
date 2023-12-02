<?php

namespace App\Models;

use App\Models\Employer;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public function employer(){
        return $this->belongsTo(Employer::class);
    }

    public function section() {
        return $this->hasMany(Section::class);
    }

    protected $fillable = [
        'employer_id',
        'title',
        'category',
        'is_paid',
    ];
    protected $attributes = [
        'is_paid' => false,
    ];
    protected $with = ['employer'];
}
