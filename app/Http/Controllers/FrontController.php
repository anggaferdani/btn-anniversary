<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Partner;
use App\Models\Profile;
use App\Models\WhyTradersChooseUs;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {
        $profile = Profile::first();
        $whyTradersChooseUs = WhyTradersChooseUs::where('status', 1)->get();
        $experiences = Experience::where('status', 1)->get();
        $partners = Partner::where('status', 1)->get();
        return view('frontend.templates.pages', compact(
            'profile',
            'whyTradersChooseUs',
            'experiences',
            'partners',
        ));
    }
}
