<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function topicProgress()
    {
        return $this->hasMany(TopicProgress::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
