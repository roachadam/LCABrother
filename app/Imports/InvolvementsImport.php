<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Involvement;

class InvolvementsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $involvements = auth()->user()->organization->involvement;

        foreach ($collection as $event) {
            $match = [
                'name' => $event['name'],
                'organization_id' => auth()->user()->organization->id,
            ];
            dd($involvements->find($match)->first()['name']);
            Date::excelToDateTimeObject($event['date']);
        }
    }


    private function setPointTotal($eventName)
    {
        // switch ($eventName) {
        //     case 'Social':
        //         return 15;
        //     case ''
        // }
    }
}
