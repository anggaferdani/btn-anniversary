<?php

namespace App\Exports;

use App\Models\Instansi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InstansiExport implements FromView
{
    
    public function view(): View
    {
        $instansis = Instansi::with('participants')->orderBy('name')->get();
        return view('backend.pages.export.export_kehadiran_instansi', compact('instansis'));
    }
}

