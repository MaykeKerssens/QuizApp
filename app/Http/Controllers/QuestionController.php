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
        //
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
        $request->validate([
            'question_file' => 'file',
            // |mimetypes:text/csv,application/json
            // |mimes:json,csv
            'topic' => 'required|filled',
            'question_text' => 'required_unless:question_file,null|string',
            'question_point_worth' => 'nullable|numeric',
            'question_type' => 'required_unless:question_file,null',
            'answer_a_text' => 'nullable|string',
            'answer_a_isCorrect' => 'nullable|boolean',
            'answer_b_text' => 'nullable|string',
            'answer_b_isCorrect' => 'nullable|boolean',
            'answer_c_text' => 'nullable|string',
            'answer_c_isCorrect' => 'nullable|boolean',
            'question_correct_answer' => 'nullable|string',
        ],[
            'question_file.file' => 'The question file must be a valid file.',
            'topic.required' => 'The topic field is required.',
            'topic.filled' => 'The topic field must be filled.',
            'question_text.required_unless' => 'The question text field is required unless a question file is provided.',
            'question_text.string' => 'The question text must be a valid string.',
            'question_point_worth.numeric' => 'The question point worth must be a numeric value.',
            'question_type.required_unless' => 'The question type field is required unless a question file is provided.',
            'answer_a_text.string' => 'Answer A must be a valid string.',
            'answer_a_isCorrect.boolean' => 'Answer A isCorrect must be a valid boolean value.',
            'answer_b_text.string' => 'Answer B must be a valid string.',
            'answer_b_isCorrect.boolean' => 'Answer B isCorrect must be a valid boolean value.',
            'answer_c_text.string' => 'Answer C must be a valid string.',
            'answer_c_isCorrect.boolean' => 'Answer C isCorrect must be a valid boolean value.',
            'question_correct_answer.string' => 'The correct answer must be a valid string.',
        ]);


        if($request->question_file) {
            dd('this is a file');
            return $this->storeFile($request);
        }
        // Redirect back with a success message
        dd('this worked??');
        return redirect()->back()->with('success', 'Question "question info" uploaded succesfully');
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
            'topic' => 'required|filled',
        ],[
            'question_file.file' => 'The question file must be a valid file.',
            'topic.required' => 'The topic field is required.',
            'topic.filled' => 'The topic field must be filled.',
        ]);

        $file = $request->file('question_file');

        // Open the CSV file
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setDelimiter(';'); // Specify the semicolon as the delimiter
        $csv->setHeaderOffset(0); // Assuming the first row contains column headers

        // Iterate through the CSV rows and insert/update questions and answers
        foreach ($csv as $row) {

            $question = Question::updateOrCreate([
                'id' => $row['id'],
                'topic_id' => 1,
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
        //
    }
}
