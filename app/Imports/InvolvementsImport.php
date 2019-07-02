<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Commons\InvolvementHelperFunctions;
use App\User;

class InvolvementsImport implements ToCollection, WithHeadingRow
{
    private $newServiceEvents = array();
    private $size;

    public function collection(Collection $involvementData)
    {
        $this->size = count($involvementData);
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
                        'points' => null //$this->getPointTotal($event['name']),
                    ];

                    $involvementEvent = $organization->addInvolvementEvent($attributes);
                    //If the event is added just add the user logs
                    if (isset($involvementEvent)) {
                        $this->addUserLogs($involvementEvent, $event, $organization);
                        array_push($this->newServiceEvents, $involvementEvent);
                    } else {
                        //if the event has already been created and added just add on to it
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


    private function addUserLogs($involvementEvent, $currentEvent, $organization)
    {
        foreach (explode(', ', $currentEvent['members_involved']) as $user) {
            $user = User::where(['name' => $user, 'organization_id' => $organization->id])->get()->first();
            if (isset($user)) {
                $user->addInvolvementLog($involvementEvent, Date::excelToDateTimeObject($currentEvent['date']));
            }
        }
    }

    public function chunkSize(): int
    {
        return $this->size;
    }

    public function getNewServiceEvents(): array
    {
        return $this->newServiceEvents;
    }
}
