<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Site;
use App\Services\JayaPay\JayaPayClient;
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

    public function bankManagement(JayaPayClient $client)
    {
        $user = Player::first();

        $payload = [
            'merchantCode' => config('qris.code'),
            'orderType' => '0',
            'method' => 'QRIS',
            'orderNum' => now()->timestamp . rand(1000, 9999),
            'payMoney' => 25000,
            'productDetail' => str($user->username . ' Deposit')->limit(90, ''),
            'notifyUrl' => config('qris.url'),
            'dateTime' => now()->format('YmdHis'),
            'expiryPeriod' => 5,
            'name' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        $response = $client->createFiatOrder($payload);

        dd($response);
        return view('bank');
    }

    public function users()
    {
        return view('user');
    }
}
