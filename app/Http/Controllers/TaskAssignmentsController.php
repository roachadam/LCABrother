<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskAssignments;

class TaskAssignmentsController extends Controller
{
    public function markTaskComplete(Request $request, TaskAssignments $TaskAssignments)
    {
        // dd($TaskAssignments);
        $TaskAssignments->completed = 1;
        $TaskAssignments->save();
        return redirect()->back();
    }
}
