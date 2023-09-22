<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Answer::create([
            'question_id' => 1,
            'text' => 'This answer is wrong',
            'isCorrect' => false,
        ]);

        Answer::create([
            'question_id' => 1,
            'text' => 'This answer is correct',
            'isCorrect' => true,
        ]);

        Answer::create([
            'question_id' => 1,
            'text' => 'This answer is wrong',
            'isCorrect' => false,
        ]);
    }
}
