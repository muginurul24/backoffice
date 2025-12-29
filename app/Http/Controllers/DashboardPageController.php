<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class DashboardPageController extends Controller
{
    public function index()
    {
        $coin = Site::where('id', Auth::user()->site_id)->first()->balance ?? 0;

        return view('dashboard', [
            'depositToday' => 0,
            'ticketToday' => 0,
            'depositAnnually' => 0,
            'coinBalance' => (int)$coin,
            'historyApprovedToday' => [],
        ]);
    }

    public function siteManagement()
    {
        return view('site');
    }

    public function bankManagement()
    {
        return view('bank', [
            'payments' => Payment::where('site_id', Auth::user()->site_id)->get(),
        ]);
    }

    public function users()
    {
        return view('user');
    }
}
