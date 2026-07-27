<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'year',
        'course_id',
    ];


    /**
     * Class belongs to a course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    /**
     * Class has many students
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


    /**
     * Class has many quizzes
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}