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
            'counter' => 0,
        ]);
    }

    public function storeUserAnswer(Request $request)
    {

        // save answer here:



        // Go to next question
        $counter = $request->counter + 1;
        $topic = Topic::find($request->topic_id);
        $questions = Question::where('topic_id', $topic->id)->orderBy('id','ASC')->get();
        $question = $questions[$counter];
        $answers = Answer::where('question_id', $question->id)->orderBy('id','ASC')->get();

        return view('quiz',[
            'topic' => $topic,
            'question' => $question,
            'answers' => $answers,
            'counter' => $counter,
        ]);
    }
}
