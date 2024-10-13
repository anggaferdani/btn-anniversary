<?php

namespace App\Http\Controllers;

use App\Models\Participant;

class SpinController extends Controller
{
    public function index()
    {
        $result = [];

        $participants = Participant::where('verification', 1)->where("attendance", 1)->where('status', 1)->where("kehadiran", "onsite")->inRandomOrder()->get();
        $participants->each(function ($participant) use (&$result) {
            $qrcode = $participant->qrcode;
            $firstChar = $qrcode[0];
            $restChar = substr($qrcode, 1);

            if (!isset($result[$firstChar])) {
                $result[$firstChar] = [];
            }

            $result[$firstChar][] = $restChar;
        });
//        dd();
        return view('spin.index', compact("result"));
    }
}
