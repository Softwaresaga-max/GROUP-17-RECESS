<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Group;
use App\Models\Attempt;
use App\Models\Warning;
use App\Models\Blacklist;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Models\Discussion;
use App\Models\DiscussionReply;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'class_id',
        'registration_code',
        'active',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];



    /**
     * User belongs to many groups
     */
    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'group_user',
            'user_id',
            'group_id'
        );
    }



    /**
     * User has many quiz attempts
     */
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }



    /**
     * Discussions created by the user
     * Used for participation grading
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }



    /**
     * Discussion replies made by the user
     * Used for participation grading
     */
    public function discussionReplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }



    /**
     * User belongs to a course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }



    /**
     * User belongs to a classroom
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }



    /**
     * User warnings
     */
    public function warnings()
    {
        return $this->hasMany(Warning::class);
    }



    /**
     * User blacklist records
     */
    public function blacklists()
    {
        return $this->hasMany(Blacklist::class);
    }



    /**
     * User activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}