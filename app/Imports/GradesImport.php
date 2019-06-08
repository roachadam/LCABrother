<?php

namespace App\Imports;

use App\Academics;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
use App\User;

class GradesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::where('name', $row['student_name'])->first();

        $currentTermGPA = $user->latestAcademics()->Current_Term_GPA;

        $academics = new Academics([
            'name' => $row['student_name'],
            'Cumulative_GPA' => $row['cumulative_gpa'],
            'Previous_Term_GPA' => $currentTermGPA, //$row['cumulative_gpa'],
            'Current_Term_GPA' => $row['term_gpa'],
            'Previous_Academic_Standing' => $row['academic_standing'],
        ]);

        if (isset($user)) {
            $user->academics()->save($academics);
        } else {
            session()->put('error', 'Could not find user' . $row['student_name']);
        }
        auth()->user()->organization->academics()->save($academics);
        $academics->updateStanding();
        return $academics;
    }
}
