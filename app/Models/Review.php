<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = [
        'course_id', 'user_id', 'rating', 'note'
    ];

    public function course()
    {
        return $this->belongsTo('App/Model/Course');
    }
}
