<?php

namespace App\Imports;

use App\Academics;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;



class GradesImport implements ToModel, WithHeadingRow
{
    //use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $alumni = auth()->user()->organization->alumni;                                                 //Gets all alumni in database

        if ($row['student_name'] !== null && !$alumni->contains('name', $row['student_name'])) {        //Prevents white space and alumni from getting entered into the database
            $user = User::where('name', $row['student_name'])->first();                                 //Finds the user with a matching name
            $academics = new Academics([                                                                //Reads the information from the file
                'name' => $row['student_name'],
                'Cumulative_GPA' => $row['cumulative_gpa'],
                'Current_Term_GPA' => $row['term_gpa'],
            ]);
            if (isset($user)) {
                $this->saveAndUpdateData($user, $academics);
            } else {
                session()->put('error', 'Could not find user' . $row['student_name']);
            }
            auth()->user()->organization->academics()->save($academics);                //Sets the organization id for the current user

            return $academics;
        } else if ($alumni->contains('name', $row['student_name'])) {
            $alum = $alumni->firstWhere('name', $row['student_name']);                  //Selects the alumni that is trying to add more grades
            DB::table('academics')->where('user_id', '=', $alum['id'])->delete();       //Removes all previous entries of that alum from the database
        }
    }

    private function saveAndUpdateData(User $user, Academics $academics)
    {
        $prevGPA = $this->getPreviousData($user)['prevGPA'];                    //Get and store the current gpa from database
        $prevStanding = $this->getPreviousData($user)['prevStanding'];          //Get and store the current academic standing from database

        $user->academics()->save($academics);                                   //Saves the excel data to the user
        $user->setPreviousData($prevGPA, $prevStanding);                        //Sets the previous standings based on the variables above
        $user->updateStanding();                                                //Re-Calculates the Standings of all members
    }

    private function getPreviousData(User $user)
    {
        /*
            If this is the very first entry an error will be thrown because the are no instances of academics.
            Then the method will return null and empty strings in order to allow the program to continue as expected
        */

        if ($user->latestAcademics() !== null) {
            return collect([
                'prevGPA' => $user->latestAcademics()->Current_Term_GPA,
                'prevStanding' => $user->latestAcademics()->Current_Academic_Standing,
            ]);
        } else {
            return collect([
                'prevGPA' => null,
                'prevStanding' => '',
            ]);
        }
    }
}
