<?php

namespace App\Imports;

use App\Academics;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class GradesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::where('name', $row['student_name'])->first();                 //Finds the user with a matching name

        $academics = new Academics([                                                //Reads the information from the file
            'name' => $row['student_name'],
            'Cumulative_GPA' => $row['cumulative_gpa'],
            'Current_Term_GPA' => $row['term_gpa'],
        ]);

        if (isset($user)) {
            //Get and store the current gpa and standing from database
            $prevGPA = $this->getPreviousData($user)['prevGPA'];
            $prevStanding = $this->getPreviousData($user)['prevStanding'];

            //Saves the excel data to the user
            $user->academics()->save($academics);

            //Sets the previous standings based on the variables above
            $user->setPreviousData($prevGPA, $prevStanding);

            //Saves the academics to the organization
            auth()->user()->organization->academics()->save($academics);

            //Re-Calculates the Standings of all members
            $user->updateStanding();
        } else {
            session()->put('error', 'Could not find user' . $row['student_name']);
        }
        return $academics;
    }
    private function getPreviousData(User $user)
    {
        /*
            If this is the very first entry an error will be thrown because the are no instances of academics.
            Then the method will return null and empty strings in order to allow the program to continue as expected
        */
        try {
            return collect([
                'prevGPA' => $user->latestAcademics()->Current_Term_GPA,
                'prevStanding' => $user->latestAcademics()->Current_Academic_Standing,
            ]);
        } catch (\Exception $e) {
            return collect([
                'prevGPA' => null,
                'prevStanding' => '',
            ]);
        }
    }
}
