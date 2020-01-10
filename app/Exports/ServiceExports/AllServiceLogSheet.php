<?php

namespace App\Exports\ServiceExports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AllServiceLogSheet implements WithHeadings, FromCollection, WithTitle, ShouldAutoSize, WithEvents
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
                        'Money Donated' => $this->addDollarSign($serviceLog->money_donated),
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

    public function title(): string
    {
        return 'All Logs';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setSize(14);
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '' . $sheet->getHighestRow())->getFont()->setSize(12);
            },
        ];
    }

    private function addDollarSign($money)
    {
        return ($money == null) ? '' : '$' . $money;
    }
}
