<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
    ];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function excludedUsers()
    {
        return $this->belongsToMany(User::class, 'posts_exclusion', 'post_id', 'user_id');
    }

    public function shares()
    {
        return $this->hasMany(PostShare::class);
    }
}