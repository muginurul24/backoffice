<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use App\Services\JayaPay\JayaPaySigner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JayaPayNotifyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, JayaPaySigner $signer)
    {
        $data = $request->all();
        Log::info(json_encode($data));
        if (!$signer->verify($data, config('qris.public_key'))) {
            return response('INVALID', 400);
        }
        return response('SUCCESS');
    }
}
