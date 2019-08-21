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
    private $involvementLogs;

    public function __construct($existingData, $organization, $users)
    {
        $this->existingData = $existingData;
        $this->organization = $organization;
        $this->users = $users;
        $this->newServiceEvents = collect();
        $this->involvementLogs = array();
    }

    public function collection(Collection $involvementData)
    {
        foreach ($involvementData as $event) {
            if (!empty($event['name'])) {
                $existingData = $this->existingData->where('name', $event['name']);
                if ($existingData->isNotEmpty()) {
                    $this->addServiceLogs($existingData, $event);
                } else {
                    $this->createServiceEvent($event);
                }
            }
        }
        InvolvementLog::insert($this->involvementLogs);
    }

    private function addServiceLogs($existingData, $event)
    {
        $existingLog = $existingData->first();
        $this->addUserLogs($existingLog, $event, $this->organization);
    }

    private function createServiceEvent($event)
    {
        $attributes = ['name' => $event['name'], 'points' => null];

        $involvementEvent = $this->organization->addInvolvementEvent($attributes, $this->newServiceEvents);
        //If the event is added just add the user logs
        if (isset($involvementEvent)) {
            $this->addUserLogs($involvementEvent, $event, $this->organization);
            $this->newServiceEvents->push($involvementEvent);
        } else {
            //Grab the event from the database and add the user logs to it
            $this->addUserLogs($this->newServiceEvents->where('name', $event['name'])->first(), $event, $this->organization);
        }
    }

    private function addUserLogs($involvementEvent, $currentEvent)
    {
        $now = Carbon::now()->toDateTimeString();
        foreach ($this->users as $user) {
            if (in_array($user['name'], explode(', ', $currentEvent['members_involved']))) {
                array_push($this->involvementLogs, [
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

    public function getInvolvementLogs(): array
    {
        return $this->involvementLogs;
    }
}
