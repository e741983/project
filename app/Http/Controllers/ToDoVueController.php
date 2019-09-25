<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ToDo as ToDo;
use App\Http\Resources\ToDoCollection as ToDoResource;

class ToDoVueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $todo = ToDo::orderBy('date', 'asc')->paginate(5);
        return ToDoResource::collection($todo);
    }

    public function store(Request $request)
    {
        $todo = new ToDo;
        $todo->text = $request->input('text');
        $todo->date = $request->input('date');
        $todo->complete = 0;
        $todo->save();

        return array();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ToDo::find($id);
        return view('register')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ToDo::find($id);
        return view('edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $todo = ToDo::find($request->to_do_id);
        $todo->text = $request->text;
        $todo->date = $request->date;
        $todo->save();

        return array();
    }

    public function mark(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->complete = $request->complete;
        $todo->save();

        return array();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = ToDo::find($id);
        $todo->delete();
        return array();
    }
}
