<?php

namespace App\Services\JayaPay;

class JayaPaySigner
{
    public function makeString(array $params): string
    {
        $params = array_filter($params, fn($v) => $v !== null && $v !== '');
        ksort($params, SORT_STRING);
        return implode('', array_map('strval', $params));
    }

    public function sign(string $plain, string $privateKeyBase64): string
    {
        $privateKey = openssl_pkey_get_private(
            "-----BEGIN PRIVATE KEY-----\n" .
            chunk_split($privateKeyBase64, 64, "\n") .
            "-----END PRIVATE KEY-----"
        );

        if (!$privateKey) {
            throw new \RuntimeException('Invalid private key');
        }

        openssl_private_encrypt(
            $plain,
            $encrypted,
            $privateKey,
            OPENSSL_PKCS1_PADDING
        );

        return base64_encode($encrypted);
    }

    public function verify(array $params, string $publicKeyBase64): bool
    {
        $sign = $params['platSign'] ?? null;
        unset($params['platSign']);

        $plain = $this->makeString($params);

        $publicKey = openssl_pkey_get_public(
            "-----BEGIN PUBLIC KEY-----\n" .
            chunk_split($publicKeyBase64, 64, "\n") .
            "-----END PUBLIC KEY-----"
        );

        openssl_public_decrypt(
            base64_decode($sign),
            $decrypted,
            $publicKey,
            OPENSSL_PKCS1_PADDING
        );

        return $plain === $decrypted;
    }
}
