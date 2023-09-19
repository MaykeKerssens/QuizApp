<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use App\Models\UserResponse;
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
        $questionsAmount = count($questions);

        return view('quiz',[
            'topic' => $topic,
            'question' => $question,
            'answers' => $answers,
            'questionsAmount' => $questionsAmount,
            'counter' => 0,

        ]);
    }

    public function storeUserAnswer(Request $request)
    {
        $currentQuestion = Question::find($request->question_id);
        $selectedAnswer = Answer::where('id', $request->selected_answer_id)->get()[0];

        // save answer here:
        UserResponse::updateOrCreate([
            'user_id' => auth()->user()->id,
            'question_id' => $currentQuestion->id,
            'answer_id' => ($currentQuestion->type == 'multipleChoice') ? $selectedAnswer->id : null,
            'response' => ($currentQuestion->type == 'openAnswer') ? $request->response : null,
            'isCorrect' => ($selectedAnswer->isCorrect == true),
        ]);

        // Go to next question
        $questions = Question::where('topic_id', $currentQuestion->topic_id)->orderBy('id','ASC')->get();

        // check if there are more questions, otherwise end quiz
        if($request->counter < ($request->questionsAmount -1)){
            $counter =  $request->counter + 1;
            $newQuestion = $questions[$counter];
            $answers = Answer::where('question_id', $newQuestion->id)->orderBy('id','ASC')->get();

            return view('quiz',[
                'question' => $newQuestion,
                'answers' => $answers,
                'questionsAmount' => $request->questionsAmount,
                'counter' => $counter,
            ]);
        }
        else{
            dd('einde quiz');
            // return view('quiz',[
            //     'question' => $newQuestion,
            //     'answers' => $answers,
            //     'questionsAmount' => $request->questionsAmount,
            //     'counter' => $counter,
            // ]);
        }
    }
}
