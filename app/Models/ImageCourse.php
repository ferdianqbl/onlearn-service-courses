<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCourse extends Model
{
    use HasFactory;

    protected $table = 'image_courses';
    protected $fillable = [
        'image', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
