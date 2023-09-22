<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'id' => 1,
            'topic_id' => 1,
            'text' => 'Is this a multiple choice question?',
            'type' => 'multipleChoice',
            // 'hint' => 'This is a hint',
            // 'point_worth' => 1,
        ]);

        Question::create([
            'topic_id' => 1,
            'text' => 'Is this an open question?',
            'type' => 'openAnswer',
            'hint' => 'This is a hint',
            'correct_answer' => 'yes',
            'point_worth' => 5,
        ]);


    }
}
