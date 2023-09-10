<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('encode_jwt')) {
    function encode_jwt(int $userId): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 604800;
        $payload = array(
            'user_id' => $userId,
            'iat' => $issuedAt,
            'exp' => $expirationTime
        );
        $key = getenv("jwt.secretKey");
        $alg = 'HS256';

        $token = JWT::encode($payload, $key, $alg);
        return $token;
    }
}

if (!function_exists('decode_jwt')) {
    function decode_jwt(string $token): mixed
    {
        $key = getenv("jwt.secretKey");
        try {
            $decodedToken = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
        return $decodedToken;
    }
}

if (!function_exists('get_bearer_token')) {
    function get_bearer_token($authorizationHeader)
    {
        $bearerTokenPattern = '/Bearer\s(\S+)/';

        if (preg_match($bearerTokenPattern, $authorizationHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }

}


