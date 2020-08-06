<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::resource('/tasks', 'TaskController@index');

Route::get('/', function() {
    // return redirect('/tasks');
    return view('welcome');
});
Route::get('/tasks', 'TaskController@index');
Route::get('/tasks/{id}', 'TaskController@show');
Route::post('/tasks', 'TaskController@store');
Route::delete('/tasks/{id}', 'TaskController@destroy');
Route::get('/list/tick', 'ListController@tick');

// Route::get('/list/tick', function() {
//     $tasks = DB::table('tasks')->select('*')->get();
//     foreach ($tasks as $task) {
//         $taskFighter = new \App\TaskFighter($task->name, $task->priority, $task->dueIn);
//         $taskFighter->tick();
//         DB::update("update tasks set priority = '{$taskFighter->priority}', dueIn = '{$taskFighter->dueIn}' where id = '{$task->id}'");
//     }
//     return 'tick';
// });
