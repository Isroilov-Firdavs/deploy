<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

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
        return view('questions.create');
    }
    public function showTest()
    {
        $questions = Question::inRandomOrder()->take(100)->get();
        return view('test.show', compact('questions'));
    }
    public function submitTest(Request $request)
    {
        $answers = $request->input('answers', []);
        $correct = 0;

        foreach ($answers as $id => $userAnswer) {
            $question = Question::find($id);
            if ($question && $question->correct_answer === $userAnswer) {
                $correct++;
            }
        }

        return view('test.result', ['correct' => $correct, 'total' => count($answers)]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validated = $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Question::create($validated);
        return back()->with('success', 'Savol saqlandi');
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
