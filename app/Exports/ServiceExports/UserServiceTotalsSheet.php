<?php

namespace App\Exports\ServiceExports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UserServiceTotalsSheet implements WithHeadings, FromCollection, WithTitle, ShouldAutoSize, WithEvents
{
    private $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        $export = collect();
        foreach ($this->users as $user) {
            $export->add([
                'Member Name' => $user->name,
                'Service Hours' => $user->getServiceHours(),
                'Money Donated' => $this->addDollarSign($user->getMoneyDonated()),
            ]);
        }
        return $export;
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Service Hours',
            'Money Donated'
        ];
    }

    public function title(): string
    {
        return 'User Totals';
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
