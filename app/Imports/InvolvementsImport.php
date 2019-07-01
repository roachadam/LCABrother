<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Commons\InvolvementHelperFunctions;
use App\User;

class InvolvementsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $involvementData)
    {
        $organization = auth()->user()->organization;

        foreach ($involvementData as $event) {
            if (!empty($event['name'])) {
                $existingData = InvolvementHelperFunctions::checkIfInvolvementEventExists($event);

                //If the event already exists add the user logs
                if ($existingData->isNotEmpty()) {
                    $existingData = $existingData->first();
                    $this->addUserLogs($existingData, $event, $organization);
                } else {
                    //Create service event
                    $attributes = [
                        'name' => $event['name'],
                        'points' => $this->getPointTotal($event['name']),
                    ];

                    $involvementEvent = $organization->addInvolvementEvent($attributes);
                    //If the event is added just add the user logs
                    if (isset($involvementEvent)) {
                        $this->addUserLogs($involvementEvent, $event, $organization);
                    } else {
                        //Grab the event from the database and add the user logs to it
                        $match = [
                            'name' => $event['name'],
                            'organization_id' => $organization->id,
                        ];
                        $involvementEvent = $organization->involvement()->where($match)->get()->first();
                        $this->addUserLogs($involvementEvent, $event, $organization);
                    }
                }
            }
        }
    }


    private function addUserLogs($InvolvementEvent, $currentEvent, $organization)
    {
        foreach (explode(', ', $currentEvent['members_involved']) as $user) {
            $user = User::where(['name' => $user, 'organization_id' => $organization->id])->get()->first();
            if (isset($user)) {
                $user->addInvolvementLog($InvolvementEvent, Date::excelToDateTimeObject($currentEvent['date']));
            }
        }
    }


    // Change this when we make it dynamic
    private function getPointTotal($eventName)
    {
        switch ($eventName) {
            case 'Socials':
                return 15;
            case 'Recruitment events':
                return 15;
            case 'Brotherhood events':
                return 10;
            case 'Alumni events':
                return 10;
            case 'Philanthropy events':
                return 10;
            case 'PI':
                return 5;
            case 'Intramurals':
                return 5;
            case 'Pay dues in full':
                return 10;
            case 'Move into the house':
                return 70;
            case 'Leadership role in another organization':
                return 15;
            case 'Attend other organizations events':
                return 10;
        }
    }
}
