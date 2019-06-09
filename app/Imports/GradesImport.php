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
        $user = User::where('name', $row['student_name'])->first();

        $academics = new Academics([
            'name' => $row['student_name'],
            'Cumulative_GPA' => $row['cumulative_gpa'],
            'Current_Term_GPA' => $row['term_gpa'],
        ]);

        if (isset($user)) {
            $prevGPA = $this->getPreviousData($user)['prevGPA'];
            $prevStanding = $this->getPreviousData($user)['prevStanding'];

            $user->academics()->save($academics);

            $user->setPreviousData($prevGPA, $prevStanding);

            auth()->user()->organization->academics()->save($academics);

            $user->updateStanding();
        } else {
            session()->put('error', 'Could not find user' . $row['student_name']);
        }
        return $academics;
    }

    private function getPreviousData(User $user)
    {
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
