<?php

namespace App\Http\Controllers;
use App\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tasks = DB::table('tasks')->select('*')->get();
        $tasks = Task::all();
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((!isset($request->name) || $request->name === "") ||
        (!isset($request->dueIn) || $request->dueIn === "") ||
        (!isset($request->priority) || $request->priority === "")) {
            return response()->json(['message' => 'incorrect request parameters'], 400);
        }
        $task = new Task;
        $task->name = $request->name;
        $task->dueIn = $request->dueIn;
        $task->priority = $request->priority;

        $task->save();

        if ($task) return $task;
        return response()->json(['message' => 'saving task failed'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['message' => 'task not found'], 404);
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        $task = Task::find($id);
        if (!$task) return response()->json(['message' => 'task not found'], 404);
        $task->name = $request->name;
        $task->dueIn = $request->dueIn;
        $task->priority = $request->priority;

        $task->save();

        if ($task) return $task;
        return response()->json(['message' => 'updating task failed'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) return response()->json(['message' => 'task not found'], 404);
        $task->delete();
        if ($task) return $task;
        return response()->json(['message' => 'destroying task failed'], 500);
    }
}
