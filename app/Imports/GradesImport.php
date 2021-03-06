<?php

namespace App\Imports;

use App\Academics;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;
use App\Commons\NotificationFunctions;

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
        if ($row['student_name'] !== null) {
            $organization = auth()->user()->organization;
            $alumni = $organization->alumni;                                                 //Gets all alumni in database
            //$row['student_name'] = $this->splitName($row['student_name']);                                  //Converts the Last, First to First Last

            if (!$alumni->contains('name', $row['student_name'])) {                                         //Prevents white space and alumni from getting entered into the database
                $user = User::findByName($row['student_name']);                                             //Finds the user with a matching name
                $academics = new Academics([                                                                //Reads the information from the file
                    'name' => $row['student_name'],
                    'Cumulative_GPA' => $row['cumulative_gpa'],
                    'Current_Term_GPA' => $row['term_gpa'],
                ]);
                if (isset($user)) {
                    $this->saveData($user, $academics);
                    $user->updateStanding();                                                //Re-Calculates the Standings of all members
                } else {
                    NotificationFunctions::alert('error', 'Could not find user' . $row['student_name']);
                }
                auth()->user()->organization->academics()->save($academics);                //Sets the organization id for the current user

                return $academics;
            } else if ($alumni->contains('name', $row['student_name'])) {
                $alum = $alumni->firstWhere('name', $row['student_name']);                  //Selects the alumni that is trying to add more grades
                DB::table('academics')->where('user_id', '=', $alum['id'])->delete();       //Removes all previous entries of that alum from the database
            }
        }
    }

    private function saveData(User $user, Academics $academics)
    {
        $prevGPA = $user->getPreviousAcademicData()['prevGPA'];                    //Get and store the current gpa from database
        $prevStanding = $user->getPreviousAcademicData()['prevStanding'];          //Get and store the current academic standing from database

        $user->academics()->save($academics);                                   //Saves the excel data to the user
        $user->setPreviousData($prevGPA, $prevStanding);                        //Sets the previous standings based on the variables above
    }

    private function splitName($string)
    {
        $array = str_replace(',', '', explode(' ', $string));
        return $array[1] . ' ' . $array[0];
    }
}
