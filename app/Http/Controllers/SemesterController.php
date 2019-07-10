<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Commons\NotificationFunctions;


class SemesterController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'semester_name' => 'required'
        ]);
        $organization = auth()->user()->organization;

        $activeSemester = $organization->getActiveSemester();
        if ($activeSemester !== null) {
            $activeSemester->update([
                'end_date' => Carbon::now(),
                'active' => false
            ]);
        }


        $attributes['active'] = true;
        $attributes['start_date'] = Carbon::now();
        NotificationFunctions::alert('success', 'Successfully created new semester');
        auth()->user()->organization->addSemester($attributes);

        return back();
    }

    public function initial(Request $request)
    {
        $attributes = $request->validate([
            'semester_name' => 'required'
        ]);
        $organization = auth()->user()->organization;

        $attributes['active'] = true;
        $attributes['start_date'] = Carbon::today()->toDateString();
        NotificationFunctions::alert('success', 'Successfully created new semester');
        auth()->user()->organization->addSemester($attributes);
        return redirect('/academicStandings/create');
    }
}
