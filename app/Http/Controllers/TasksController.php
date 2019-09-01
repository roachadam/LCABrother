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
        $incompleteTasks = $user->getIncompleteTasks();
        $completeTasks = $user->getCompleteTasks();

        $tasks = $user->getTasksAssigned();
        
        return view('tasks.index', compact('completeTasks', 'tasks','incompleteTasks'));
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
             'users' => ['required'],
        ]);

        $users = $attributes['users'];
        unset($attributes['users']);

        $user = auth()->user();
        $attributes['deadline'] = date('Y-m-d', strtotime($attributes['deadline']));
        $attributes['user_id'] = $user->id;
        $task = $user->organization->createTask($attributes);
        $task->assignUsersToTask($users);
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tasks $task)
    {
        $taskAssignments = $task->tasksAssignments;
        return view('tasks.edit', compact('task', 'taskAssignments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $task)
    {
        $attributes = request()->all();
        $assignedUsers = $task->getAllUsersAssigned();

        if(isset($attributes['users']))
        {
           foreach($assignedUsers as $user)
           {
                if(!in_array($user->id,$attributes['users']))
                {
                    $task->unAssignUser($user->id);
                }
            }

            $task->assignUsersToTask($attributes['users']);
        }
        else
        {
            foreach($assignedUsers as $user)
            {
                $task->unAssignUser($user->id);
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $task)
    {
        $task->delete();
        return redirect('/tasks');
    }


}
