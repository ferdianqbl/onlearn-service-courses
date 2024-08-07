<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $table = 'mentors';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'name', 'email', 'profile', 'profession'
    ];

    public function courses()
    {
        // return $this->hasMany('App\Models\Course')->orderBy('id', 'ASC');
        return $this->hasMany(Course::class)->orderBy('id', 'ASC');
    }
}
