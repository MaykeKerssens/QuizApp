<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'question_id', 'text', 'isCorrect'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userResponse()
    {
        return $this->hasMany(userResponse::class);
    }
}
