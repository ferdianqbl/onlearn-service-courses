<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters'; // this model is linked to the chapters table

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'name',
        'course_id'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson')->orderBy('id', 'ASC');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
