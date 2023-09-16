<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard(){

        $topics = Topic::all();
        return view('dashboard',[
            'topics' => $topics
        ]);
    }

        /**
     * Display the specified resource.
     */
    public function quiz(string $id)
    {
        $topic = Topic::find($id);

        $questions = Question::where('topic_id', $id)->orderBy('id','ASC')->get();

        $question = $questions[0];
        $answers = Answer::where('question_id', $question->id)->orderBy('id','ASC')->get();

        return view('quiz',[
            'topic' => $topic,
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    public function storeUserAnswer(string $question_id)
    {
        // for($i = 0; $i <= count($questions);){


        // }
    }
}
