<?php

namespace App\Lib\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

final class NexusggrApi
{
    private string $agent;
    private string $token;
    private string $endpoint;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->agent = config('nexusggr.agent');
        $this->token = config('nexusggr.token');
        $this->endpoint = config('nexusggr.endpoint');
    }

    /**
     * @throws ConnectionException
     */
    public function register(string $username): JsonResponse
    {
        return $this->call(
            method: 'user_create',
            payload: ['user_code' => $username]
        );
    }

    /**
     * @throws ConnectionException
     */
    public function transaction(string $username, string $type, int $amount): JsonResponse
    {
        return $this->call(
            method: 'user_' . $type,
            payload: [
                'user_code' => $username,
                'amount' => $amount,
            ]
        );
    }

    /**
     * @throws ConnectionException
     */
    public function resetUserBalance(?string $username = null): JsonResponse
    {
        $payload = is_null($username)
            ? ['all_users' => true]
            : ['user_code' => $username];

        return $this->call(
            method: 'user_withdraw_reset',
            payload: $payload
        );
    }

    /**
     * @throws ConnectionException
     */
    public function launchGame(string $username, string $provider, string $game, string $lang = 'id'): JsonResponse
    {
        return $this->call(
            method: 'game_launch',
            payload: [
                'user_code' => $username,
                'provider_code' => $provider,
                'game_code' => $game,
                'lang' => $lang
            ]
        );
    }

    /**
     * @throws ConnectionException
     */
    public function info(?string $username = null): JsonResponse
    {
        $payload = is_null($username)
            ? []
            : ['user_code' => $username];

        return $this->call(
            method: 'money_info',
            payload: $payload
        );
    }

    /**
     * @throws ConnectionException
     */
    public function providers(): JsonResponse
    {
        return $this->call(method: 'provider_list');
    }

    /**
     * @throws ConnectionException
     */
    public function games(string $provider): JsonResponse
    {
        return $this->call(method: 'game_list', payload: ['provider_code' => $provider]);
    }

    /**
     * @throws ConnectionException
     */
    public function turnover(string $username): JsonResponse
    {
        return $this->call(method: 'get_game_log', payload: [
            'user_code' => $username,
            'game_type' => 'slot',
            'start' => now()->subMonth()->format('Y-m-d 00:00:00'),
            'end' => now()->format('Y-m-d H:i:s'),
            'page' => 0,
            'perPage' => 3000
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function transferStatus(string $username, string $signature): JsonResponse
    {
        return $this->call(method: 'transfer_status', payload: [
            'user_code' => $username,
            'agent_sign' => $signature
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function currentPlayingUsers(): JsonResponse
    {
        return $this->call(method: 'call_players');
    }

    /**
     * @throws ConnectionException
     */
    public function listCall(string $provider, string $game): JsonResponse
    {
        return $this->call(method: 'call_list', payload: [
            'provider_code' => $provider,
            'game_code' => $game
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function applyCall(string $username, string $provider, string $game, int $rtp, int $type): JsonResponse
    {
        return $this->call(method: 'call_apply', payload: [
            'provider_code' => $provider,
            'game_code' => $game,
            'user_code' => $username,
            'call_rtp' => $rtp,
            'call_type' => $type
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function historyCall(): JsonResponse
    {
        return $this->call(method: 'call_history', payload: [
            'offset' => 0,
            'limit' => 100
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function cancelCall(int $id): JsonResponse
    {
        return $this->call(method: 'call_cancel', payload: [
            'call_id' => $id
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function controlUserRtp(string $username, string $provider, int $rtp): JsonResponse
    {
        return $this->call(method: 'control_rtp', payload: [
            'provider_code' => $provider,
            'user_code' => $username,
            'rtp' => $rtp
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function setRtp(array $users, int $rtp): JsonResponse
    {
        return $this->call(method: 'control_users_rtp', payload: [
            'user_codes' => json_encode($users),
            'rtp' => $rtp
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function call(string $method, array $payload = []): JsonResponse
    {
        $body = [
            'method' => $method,
            'agent_code' => $this->agent,
            'agent_token' => $this->token,
            ...$payload,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->asJson()
            ->timeout(15)
            ->retry(5, 200)
            ->post($this->endpoint, $body);

        if ($response->failed()) {
            throw new HttpResponseException(response()->json(['errors' => ['message' => sprintf('NexusGGR request failed (%s): HTTP %d', $method, $response->status())]], 400));
        }

        return $response->json();
    }
}
