<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ParticipationGrade extends Model
{
    protected $fillable = ['user_id', 'group_id', 'discussion_count', 'post_count', 'score', 'computed_at'];

    public function user() { return $this->belongsTo(User::class); }
    public function group() { return $this->belongsTo(Group::class); }
}