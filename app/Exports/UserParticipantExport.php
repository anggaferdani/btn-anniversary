<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserParticipantExport implements FromView
{
    protected $userParticipants;

    public function __construct($userParticipants)
    {
        $this->userParticipants = $userParticipants;
    }

    public function view(): View
    {
        return view('backend.pages.user-participant-export', [
            'userParticipants' => $this->userParticipants
        ]);
    }
}
