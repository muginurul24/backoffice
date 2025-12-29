<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Services\JayaPay\JayaPayClient;
use Illuminate\Http\Client\ConnectionException;

class JayaPayController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function fiat(string $method, int $amount, Player $user, JayaPayClient $client)
    {
        $payload = [
            'merchantCode' => config('qris.code'),
            'orderType' => '0',
            'method' => $method,
            'orderNum' => now()->timestamp,
            'payMoney' => $amount,
            'productDetail' => $user->username . ' Deposit: ' . number_format($amount),
            'notifyUrl' => config('qris.url'),
            'dateTime' => now()->format('YmdHis'),
            'expiryPeriod' => 1440,
            'name' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        return response()->json(
            $client->createFiatOrder($payload)
        );
    }
}
