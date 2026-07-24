<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blacklisted_at',
        'expires_at',
        'active',
    ];

    protected $casts = [
        'blacklisted_at' => 'datetime',
        'expires_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}