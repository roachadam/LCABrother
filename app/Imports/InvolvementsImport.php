<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use App\InvolvementLog;

class InvolvementsImport implements ToCollection, WithHeadingRow
{
    private $newServiceEvents;
    private $existingData;
    private $organization;
    private $users;
    private $eventLogs;

    public function __construct($existingData = null, $organization, $users)
    {
        $this->existingData = $existingData;
        $this->organization = $organization;
        $this->users = $users;
        $this->newServiceEvents = collect();
        $this->eventLogs = array();
    }

    public function collection(Collection $involvementData)
    {

        foreach ($involvementData as $event) {
            if (!empty($event['name'])) {
                $existingData = $this->existingData->where('name', $event['name']);
                //If the event already exists add the user logs
                if ($existingData->isNotEmpty()) {
                    $existingLog = $existingData->first();
                    $this->addUserLogs($existingLog, $event, $this->organization);
                } else {
                    //Create service event
                    $attributes = [
                        'name' => $event['name'],
                        'points' => null //$this->getPointTotal($event['name']),
                    ];

                    $involvementEvent = $this->organization->addInvolvementEvent($attributes, $this->newServiceEvents);
                    //If the event is added just add the user logs
                    if (isset($involvementEvent)) {
                        $this->addUserLogs($involvementEvent, $event, $this->organization);
                        $this->newServiceEvents->push($involvementEvent);
                    } else {
                        //Grab the event from the database and add the user logs to it
                        $involvementEvent = $this->newServiceEvents->where('name', $event['name'])->first();
                        $this->addUserLogs($involvementEvent, $event, $this->organization);
                    }
                }
            }
        }
        InvolvementLog::insert($this->eventLogs);
    }


    private function addUserLogs($involvementEvent, $currentEvent)
    {
        $now = Carbon::now()->toDateTimeString();
        foreach ($this->users as $user) {
            if (in_array($user['name'], explode(', ', $currentEvent['members_involved']))) {
                array_push($this->eventLogs, [
                    'organization_id' => $this->organization->id,
                    'involvement_id' => $involvementEvent->id,
                    'user_id' => $user->id,
                    'date_of_event' => Date::excelToDateTimeObject($currentEvent['date']),
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
    }

    public function getNewServiceEvents(): collection
    {
        return $this->newServiceEvents;
    }

    public function getImportData(): array
    {
        return $this->eventLogs;
    }
}
