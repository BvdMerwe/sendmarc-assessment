<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Tick all the tasks in list
     *
     * @return \Illuminate\Http\Response
     */
    public function tick()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $taskFighter = new \App\TaskFighter($task->name, $task->priority, $task->dueIn);
            $taskFighter->tick();

            $task->priority = $taskFighter->priority;
            $task->dueIn = $taskFighter->dueIn;

            $task->save();

            if (!$task) return response()->json(['message' => 'Unexpected error - tick failed'], 500);
        }
        return $tasks;
    }
}
