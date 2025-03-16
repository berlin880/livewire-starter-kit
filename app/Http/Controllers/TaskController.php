<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use function Livewire\Volt\title;

class TaskController extends Controller
{
    public function index(){
        $tasks=Task::all();
        return response()->json($tasks,200);    
    }
    //
    public function store(Request $request){
        $task=Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'priority' => $request->priority,
        ]);
        return response()->json($task,200);
}
public function destroy($id){
    $task=Task::find($id);
    $task->delete();
   // Reorder IDs to be sequential
   Task::statement('SET @count = 0;');
   Task::statement('UPDATE tasks SET id = @count := @count + 1;');

   // Reset auto-increment to start from the next ID
   Task::statement('ALTER TABLE tasks AUTO_INCREMENT = 1;');
    return response()->json(null,204);
}
public function update(Request $request,$id){
    $task=Task::findOrFail($id);
    $task->update([
        'title'=>$request->title,
        'description'=>$request->description,
        'priority' => $request->priority,
    ]);
    return response()->json($task,200);
}
public function show($id){
    $task=Task::find($id);
    return response()->json($task,200);
}
}
