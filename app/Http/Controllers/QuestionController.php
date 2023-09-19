<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
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
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Fix fileupload validation to check for correct filetype
        $request->validate([
            'question_file' => 'required|file',
            // |mimetypes:text/csv,application/json
            // mimes:json,csv
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
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Questions uploaded successfully');
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
