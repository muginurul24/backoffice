<?php

namespace App\Services\JayaPay;

use RuntimeException;

class JayaPaySigner
{
    public function makeString(array $params): string
    {
        $params = array_filter($params, static fn($v) => $v !== null && $v !== '');

        ksort($params, SORT_STRING);

        return implode('', array_map('strval', $params));
    }

    public function sign(string $plain, string $privateKeyBase64): string
    {
        $privatePem = $this->wrapPrivateKey($privateKeyBase64);
        $privateKey = openssl_pkey_get_private($privatePem);

        if (!$privateKey) {
            throw new RuntimeException('Invalid private key');
        }

        $details = openssl_pkey_get_details($privateKey);
        $keyBytes = intdiv($details['bits'], 8);        // 1024 => 128 bytes
        $maxChunk = $keyBytes - 11;                    // PKCS1 padding => 117 bytes

        $crypto = '';
        foreach (str_split($plain, $maxChunk) as $chunk) {
            $ok = openssl_private_encrypt($chunk, $encrypted, $privateKey, OPENSSL_PKCS1_PADDING);
            if (!$ok) {
                throw new RuntimeException('Private encrypt failed: ' . openssl_error_string());
            }
            $crypto .= $encrypted; // BINARY concat
        }

        return base64_encode($crypto);
    }

    public function verify(array $params, string $publicKeyBase64): bool
    {
        $sign = $params['platSign'] ?? $params['sign'] ?? null;
        if (!$sign) {
            return false;
        }

        unset($params['platSign'], $params['sign']);

        $plain = $this->makeString($params);

        $publicPem = $this->wrapPublicKey($publicKeyBase64);
        $publicKey = openssl_pkey_get_public($publicPem);

        if (!$publicKey) {
            throw new RuntimeException('Invalid public key');
        }

        $details = openssl_pkey_get_details($publicKey);
        $keyBytes = intdiv($details['bits'], 8); // 1024 => 128

        $data = base64_decode($sign, true);
        if ($data === false) {
            return false;
        }

        $decrypted = '';
        foreach (str_split($data, $keyBytes) as $chunk) {
            $ok = openssl_public_decrypt($chunk, $out, $publicKey, OPENSSL_PKCS1_PADDING);
            if (!$ok) {
                // kalau decrypt fail, langsung false
                return false;
            }
            $decrypted .= $out;
        }

        return hash_equals($plain, $decrypted);
    }

    private function wrapPrivateKey(string $base64): string
    {
        return "-----BEGIN PRIVATE KEY-----\n"
            . chunk_split(trim($base64), 64, "\n")
            . "-----END PRIVATE KEY-----\n";
    }

    private function wrapPublicKey(string $base64): string
    {
        return "-----BEGIN PUBLIC KEY-----\n"
            . chunk_split(trim($base64), 64, "\n")
            . "-----END PUBLIC KEY-----\n";
    }
}
