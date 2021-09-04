<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Carbon\Carbon;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Question::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today_questions = Question::whereDate('created_at', Carbon::today())->count() ;
        if($today_questions>100){return "Questions daily limit exceeded 100Q/day";}
        else{
        $request->validate([
            'title' => 'required|starts_with:What,When,Where,Who,Why,Whose,Which,How,what,when,where,who,why,whose,which,how|ends_with:?'
        ]);
        $title = $request->get('title');
        $body = $request->get('body');
        $author = $request->get('author');

        $host = $request->getSchemeAndHttpHost();
        $id = Question::latest('id')->first()->id + 1;
        $answers = $host.'/api/answers/question/'.$id;

        if(is_null($author)) $author="anonymous";

        return Question::create([
            'title' => $title,
            'body' => $body,
            'author' => $author,
            'answers' => $answers
        ], 201);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Question::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Question::destroy($id);
    }

    public function search($title)
    {
        return Question::where('question', 'like', '%'.$title.'%')->get();
    }
}
