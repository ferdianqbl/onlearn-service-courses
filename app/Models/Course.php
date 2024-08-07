<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses'; // this model is linked to the courses table

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    protected $fillable = [
        'name',
        'certificate',
        'thumbnail',
        'type',
        'status',
        'price',
        'level',
        'description',
        'mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('id', 'ASC');
    }

    public function images()
    {
        return $this->hasMany(ImageCourse::class)->orderBy('id', 'DESC');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('id', 'ASC');
    }
}
