<?php

namespace App\Http\Controllers;

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
        return view('quiz',[
            'topic' => $topic
        ]);
    }
}
