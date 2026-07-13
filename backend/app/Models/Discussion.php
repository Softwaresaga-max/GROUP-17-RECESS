<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;


    protected $fillable = [

        'title',
        'content',
        'user_id',
        'group_id',
        'category',
        'is_active',
        'views'

    ];



    /**
     * Discussion belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }




    /**
     * Discussion belongs to a Group
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }




    /**
     * Discussion has many replies
     */
    public function replies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

public function posts()
    {
        return $this->hasMany(Post::class);
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