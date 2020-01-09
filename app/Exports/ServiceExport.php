<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceExport implements WithHeadings, FromCollection
{
    private $serviceEvents;

    public function __construct($serviceEvents)
    {
        $this->serviceEvents = $serviceEvents;
    }

    public function collection()
    {
        $export = collect();
        foreach ($this->serviceEvents as $serviceEvent) {
            if (isset($serviceEvent->serviceLogs)) {
                foreach ($serviceEvent->serviceLogs as $serviceLog) {
                    $export->add([
                        'Member Name' => $serviceLog->user->name,
                        'Involvement Event' => $serviceEvent->name,
                        'Date' => $serviceEvent->date_of_event,
                        'Money Donated' => $serviceLog->money_donated,
                        'Hours Served' => $serviceLog->hours_served,
                    ]);
                }
            }
        }
        return $export;
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Involvement Event',
            'Date',
            'Money Donated',
            'Hours Served'
        ];
    }
}
