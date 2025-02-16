<?php

namespace CoolView\CSRFService;

final class CSRFService{

    private static string $sessionKey = '_csrf_token';

    public static function getToken(): string{
        if (!isset($_SESSION)) {
            session_start();
        }

        if (empty($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::$sessionKey];
    }

    public static function validateToken(string $token): bool{
        if (!isset($_SESSION)) {
            session_start();
        }

        return isset($_SESSION[self::$sessionKey]) && hash_equals($_SESSION[self::$sessionKey], $token);
    }

    public static function resetToken(): void {
        if (!isset($_SESSION)) {
            session_start();
        }

        unset($_SESSION[self::$sessionKey]);
    }
}