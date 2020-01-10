<?php

namespace App\Exports\ServiceExports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ServiceExport implements WithMultipleSheets
{
    private $serviceEvents;

    public function __construct($serviceEvents)
    {
        $this->serviceEvents = $serviceEvents;
    }

    public function sheets(): array
    {
        return [
            new AllServiceLogSheet($this->serviceEvents),
            new UserServiceTotalsSheet(auth()->user()->organization->getActiveMembers()),
        ];
    }
}
