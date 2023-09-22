<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use League\Csv\Reader;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::orderBy('topic_id', 'ASC')->get();
        $answers = Answer::orderBy('id', 'ASC')->get();
        return view('question.index', [
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::all();
        return view('question.create', [
            'topics' => $topics,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Fix fileupload validation to check for correct filetype
        // TODO: Make it so only one MultipleCHoice question can be correct
        $request->validate([
            'question_file' => 'file',
            // |mimetypes:text/csv,application/json
            // |mimes:json,csv
            'selected_topic' => 'required|filled',
            // 'question_text' => 'required_unless:question_file,null|string',
            'question_text' => 'nullable|string',
            'question_point_worth' => 'nullable|numeric',
            // 'question_type' => 'required_unless:question_file,null',
            'question_type' => 'nullable',
            'answer_a_text' => 'nullable|string',
            'answer_a_isCorrect' => 'nullable',
            'answer_b_text' => 'nullable|string',
            'answer_b_isCorrect' => 'nullable',
            'answer_c_text' => 'nullable|string',
            'answer_c_isCorrect' => 'nullable',
            'question_correct_answer' => 'nullable|string',
        ],[
            'question_file.file' => 'The question file must be a valid file.',
            'selected_topic.required' => 'The topic field is required.',
            'selected_topic.filled' => 'The topic field must be filled.',
            'question_text.required_unless' => 'The question text field is required unless a question file is provided.',
            'question_text.string' => 'The question text must be a valid string.',
            'question_point_worth.numeric' => 'The question point worth must be a numeric value.',
            'question_type.required_unless' => 'The question type field is required unless a question file is provided.',
            'answer_a_text.string' => 'Answer A must be a valid string.',
            'answer_b_text.string' => 'Answer B must be a valid string.',
            'answer_c_text.string' => 'Answer C must be a valid string.',
            'question_correct_answer.string' => 'The correct answer must be a valid string.',
        ]);

        if($request->question_file) {
            return $this->storeFile($request);
        } else{

            $topic = Topic::where('name', $request->input('selected_topic'))->get()[0];

            $question = Question::updateOrCreate([
                'topic_id' => $topic->id,
                'text' => $request->question_text,
                'type' => $request->question_type,
                // 'hint' => $request->hint,
                'point_worth' => $request->question_point_worth ? $request->question_point_worth : 1,
            ]);

            if($request->question_type == "multipleChoice"){

                Answer::updateOrCreate([
                    'question_id' => $question->id,
                    'text' => $request->answer_a_text,
                    'isCorrect' => $request->has('answer_a_isCorrect') ? true : false,
                ]);
                Answer::updateOrCreate([
                    'question_id' => $question->id,
                    'text' => $request->answer_b_text,
                    'isCorrect' => $request->has('answer_b_isCorrect') ? true : false,
                ]);
                Answer::updateOrCreate([
                    'question_id' => $question->id,
                    'text' => $request->answer_c_text,
                    'isCorrect' => $request->has('answer_c_isCorrect') ? true : false,
                ]);


            } elseif($request->question_type == "openAnswer"){
                $question->correct_answer = $request->question_correct_answer;
                $question->save();
            }

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Question added successfully');
        }

    }



    /**
     * Store files uploaded by users
     */
    public function storeFile(Request $request)
    {
        // TODO: Fix fileupload validation to check for correct filetype
        $request->validate([
            'question_file' => 'file',
            // |mimetypes:text/csv,application/json
            // |mimes:json,csv
            'selected_topic' => 'required|filled',
        ],[
            'question_file.file' => 'The question file must be a valid file.',
            'selected_topic.required' => 'The topic field is required.',
            'selected_topic.filled' => 'The topic field must be filled.',
        ]);
        $topic = Topic::where('name', $request->input('selected_topic'))->get()[0];
        $file = $request->file('question_file');

        // Open the CSV file
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setDelimiter(';'); // Specify the semicolon as the delimiter
        $csv->setHeaderOffset(0); // Assuming the first row contains column headers

        // Iterate through the CSV rows and insert/update questions and answers
        foreach ($csv as $row) {

            $question = Question::updateOrCreate([
                'id' => $row['id'],
                'topic_id' => $topic->id,
                'text' => $row['question'],
                'type' => "multipleChoice",
            ]);

            Answer::updateOrCreate([
                'question_id' => $question->id,
                'text' => $row['answer_a'],
                'isCorrect' => ($row['correct_answer'] == 'a' || $row['correct_answer'] == 'A'),
            ]);
            Answer::updateOrCreate([
                'question_id' => $question->id,
                'text' => $row['answer_b'],
                'isCorrect' => ($row['correct_answer'] == 'b' || $row['correct_answer'] == 'B'),
            ]);
            Answer::updateOrCreate([
                'question_id' => $question->id,
                'text' => $row['answer_c'],
                'isCorrect' => ($row['correct_answer'] == 'c' || $row['correct_answer'] == 'C'),
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return redirect()->route('questions.index')->with('error', 'Question not found');
        }

        if($question->type == "multipleChoice"){
            $answers = Answer::where('question_id', $question->id)->get();
            foreach($answers as $answer){
                $answer->delete();
            }

        }
        $questionText = $question->text;
        $question->delete();

        return redirect()->route('questions.index')->with('success', "Question '$questionText' deleted successfully");
    }
}
