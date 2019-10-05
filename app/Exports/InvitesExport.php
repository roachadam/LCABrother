<?php

namespace App\Exports;

use App\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvitesExport implements WithHeadings, FromCollection
{
    private $event;
    private $invites;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->invites = $event->invites;
    }

    public function collection()
    {
        $export = collect();
        foreach ($this->invites as $invite) {
            $export->add([
                'Member Name' => $invite->user->name,
                'Number of Invites' => $invite->guest_name,
            ]);
        }
        return $export;
    }

    public function headings(): array
    {
        return [
            'Member Name',
            'Guest Name',
        ];
    }
}
