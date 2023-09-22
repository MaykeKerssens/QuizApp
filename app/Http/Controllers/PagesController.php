<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use App\Models\UserResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard()
    {

        $topics = Topic::all();
        return view('dashboard', [
            'topics' => $topics
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function quiz(string $id)
    {
        $topic = Topic::find($id);
        $questions = Question::where('topic_id', $id)->orderBy('id', 'ASC')->get();
        $question = $questions[0];
        $answers = Answer::where('question_id', $question->id)->orderBy('id', 'ASC')->get();
        $questionsAmount = count($questions);

        return view('quiz', [
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
        $isCorrect = true;
        $selectedAnswer = null;

        if($currentQuestion->type == 'multipleChoice'){
            $selectedAnswer = Answer::where('id', $request->selected_answer_id)->first();
            $isCorrect = $selectedAnswer->isCorrect;
        }
        else{
            $isCorrect = (strtolower($request->response) == strtolower($currentQuestion->correct_answer));
        }

        // save answer here:
        UserResponse::updateOrCreate([
            'user_id' => auth()->user()->id,
            'topic_id' => $currentQuestion->topic_id,
            'question_id' => $currentQuestion->id,
            'answer_id' => ($currentQuestion->type == 'multipleChoice') ? $selectedAnswer->id : null,
            'response' => ($currentQuestion->type == 'openAnswer') ? $request->response : null,
            'isCorrect' => $isCorrect,
        ]);

        $questions = Question::where('topic_id', $currentQuestion->topic_id)->orderBy('id', 'ASC')->get();

        // check if there are more questions, otherwise end quiz
        if ($request->counter < ($request->questionsAmount - 1)) {
            $counter =  $request->counter + 1;
            $newQuestion = $questions[$counter];
            $answers = Answer::where('question_id', $newQuestion->id)->orderBy('id', 'ASC')->get();

            return view('quiz', [
                'question' => $newQuestion,
                'answers' => $answers,
                'questionsAmount' => $request->questionsAmount,
                'counter' => $counter,
            ]);
        } else {
            return $this->showResults($currentQuestion->topic->id);
        }
    }


    public function showResults(string $topic_id){

        $userResponses = UserResponse::where('topic_id', $topic_id)->where('user_id', auth()->user()->id) ->orderBy('question_id', 'ASC')->get();
        $questions = Question::where('topic_id', $topic_id)->orderBy('id', 'ASC')->get();
        $questionsAmount = count($questions);
        $topic = Topic::where('id', $topic_id)->orderBy('id', 'ASC')->get()[0];

        return view('results', [
            'userResponses' => $userResponses,
            'questions' => $questions,
            'questionsAmount' => $questionsAmount,
            'topic' => $topic,
        ]);
    }
}
