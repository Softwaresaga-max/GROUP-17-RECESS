<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
    ];


    /**
     * Course has many classes
     */
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }


    /**
     * Course has many students
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


    /**
     * Course has many quizzes
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}