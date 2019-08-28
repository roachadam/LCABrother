<?php

namespace App\Http\Controllers;

use App\Tasks;
use App\TaskAssignments;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        // $myTasks = $user->organization->tasks->load(['user', 'tasksAssignments']);
        $assignedTasks = $user->getAssignedTasks();
        $tasks = $user->getTasksAssigned();
        // dd($assigneeTasks[0]->getAllUsersAssigned());
        return view('tasks.index', compact('assignedTasks', 'tasks'));
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
        $attributes = request()->validate([
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'deadline' => ['required'],
        ]);
        $user = auth()->user();
        unset($attributes['_token']);
        $attributes['deadline'] = date('Y-m-d', strtotime($attributes['deadline']));
        $attributes['user_id'] = $user->id;
        $task = $user->organization->createTask($attributes);
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Tasks $task)
    {
        // dd($task);
        $taskAssignments = $task->tasksAssignments;
        // dd($taskAssignments);
        return view('tasks.edit', compact('task','taskAssignments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks)
    {
        //
    }
    public function markTaskComplete(Request $request, TaskAssignments $TaskAssignments){
        $TaskAssignments->completed = 1;
        $TaskAssignments->save();
        return redirect()->back();

    }
}
