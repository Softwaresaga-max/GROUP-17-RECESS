<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;


    protected $fillable = [
    'title',
    'description',
    'start_datetime',
    'end_datetime',
    'course_id',
    'class_room_id',
    'status',
    'user_id',
    'is_active',
];

protected $casts = [

    'start_datetime'=>'datetime',
    'end_datetime'=>'datetime',
    'is_active'=>'boolean',

];



    /**
     * Quiz belongs to lecturer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /**
     * Quiz has many questions
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    



    /**
     * Quiz has many student attempts
     */
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function course()
{
    return $this->belongsTo(Course::class);
}

public function classRoom()
{
    return $this->belongsTo(ClassRoom::class);
}

}