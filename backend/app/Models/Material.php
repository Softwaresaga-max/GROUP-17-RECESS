<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'file_path',
        'group_id',
        'user_id'
    ];


    /**
     * Material belongs to a discussion group
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    /**
     * Material uploaded by a user (lecturer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}