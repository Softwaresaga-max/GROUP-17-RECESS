<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * A group has many students/users
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    /**
     * A group has many discussions
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }


    /**
     * A group has many learning materials
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}