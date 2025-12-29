<?php

namespace App\Services\JayaPay;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class JayaPayClient
{
    public function __construct(
        protected JayaPaySigner $signer
    )
    {
    }

    /**
     * @throws ConnectionException
     */
    private function post(string $url, array $params)
    {
        $str = $this->signer->makeString($params);
        $params['sign'] = $this->signer->sign(
            $str,
            config('qris.private_key')
        );

        return Http::asJson()->post($url, $params)->json();
    }

    /** ========== FIAT COLLECTION ==========
     * @throws ConnectionException
     */
    public function createFiatOrder(array $params)
    {
        return $this->post(
            config('qris.endpoint') . '/gateway/prepaidOrder',
            $params
        );
    }

    /** ========== DIGITAL COLLECTION ==========
     * @throws ConnectionException
     */
    public function createCryptoOrder(array $params)
    {
        return $this->post(
            config('qris.endpoint') . '/gateway/pay',
            $params
        );
    }

    /** ========== PAYOUT ==========
     * @throws ConnectionException
     */
    public function payout(array $params)
    {
        return $this->post(
            config('qris.endpoint') . '/gateway/cash',
            $params
        );
    }

    /** ========== QUERY ==========
     * @throws ConnectionException
     */
    public function queryGateway(array $params)
    {
        return $this->post(
            config('qris.endpoint') . '/gateway/query',
            $params
        );
    }
}
