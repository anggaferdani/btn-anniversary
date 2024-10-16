<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ParticipantExport implements FromView
{
    protected $participants;

    public function __construct($participants)
    {
        $this->participants = $participants;
    }

    public function view(): View
    {
        return view('backend.pages.participant-export', [
            'participants' => $this->participants
        ]);
    }
}
