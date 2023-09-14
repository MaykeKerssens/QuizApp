<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'text', 'type', 'hint', 'correct_answer', 'point_worth'];


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function userResponse()
    {
        return $this->hasMany(UserResponse::class);
    }

}
