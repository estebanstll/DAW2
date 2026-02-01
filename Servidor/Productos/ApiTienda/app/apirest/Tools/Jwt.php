<?php
namespace App\Apirest\Tools;

class Jwt
{
    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        $padding = 4 - (strlen($data) % 4);
        if ($padding < 4) {
            $data .= str_repeat('=', $padding);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function generate(array $payload, int $ttl = 3600): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;

        $secret = self::getSecret();

        $base64Header = self::base64UrlEncode(json_encode($header));
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);
        $base64Signature = self::base64UrlEncode($signature);

        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    public static function validate(string $token)
    {
        error_log("=== JWT VALIDATE START ===");
        error_log("Token: " . substr($token, 0, 50) . "...");
        
        $parts = explode('.', $token);
        error_log("Parts count: " . count($parts));
        if (count($parts) !== 3) {
            error_log("FAIL: Token parts != 3");
            return false;
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        $secret = self::getSecret();
        error_log("Secret: " . $secret);

        $expectedSig = self::base64UrlEncode(hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true));
        error_log("Expected sig: " . substr($expectedSig, 0, 30) . "...");
        error_log("Received sig: " . substr($base64Signature, 0, 30) . "...");

        if (!hash_equals($expectedSig, $base64Signature)) {
            error_log("FAIL: Signature mismatch");
            return false;
        }

        $payloadJson = self::base64UrlDecode($base64Payload);
        $payload = json_decode($payloadJson, true);
        error_log("Payload decoded: " . ($payload ? 'OK' : 'FAIL'));
        if (!$payload) {
            error_log("FAIL: Payload decode failed");
            return false;
        }

        if (isset($payload['exp']) && time() > $payload['exp']) {
            error_log("FAIL: Token expired (exp: {$payload['exp']}, now: " . time() . ")");
            return false;
        }

        error_log("JWT VALIDATE SUCCESS");
        return $payload;
    }

    private static function getSecret(): string
    {
        // Secret simple por defecto. Cambia esto en producción o en config.ini si quieres.
        return 'mi_secreto_local_2026_change_me';
    }
}
