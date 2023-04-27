<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $table = 'mentors';
    protected $fillable = [
        'name', 'email', 'profile', 'profession'
    ];

    public function course()
    {
        return $this->hasMany('App\Models\Course')->orderBy('id', 'ASC');
    }
}
