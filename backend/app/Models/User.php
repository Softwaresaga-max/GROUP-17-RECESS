<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Group;
use App\Models\Attempt;

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

    public function course()
{
    return $this->belongsTo(Course::class);
}

public function classRoom()
{
    return $this->belongsTo(ClassRoom::class);
}
}