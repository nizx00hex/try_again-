<?php

declare(strict_types=1);

class Password
{
    private const MIN_LENGTH = 10;
    private const MAX_LENGTH = 4096;

    // Common passwords list
    private const BLACKLIST = [
        'password', 'password123', 'admin123', '12345678', 'qwerty1234',
        'letmein1', 'welcome1', 'default123', 'changeme123'
    ];

    // Validates password complexity, length, and common patterns.
    public static function validate(string $password): void
    {
        if (strlen($password) < self::MIN_LENGTH) {
            throw new InvalidArgumentException('Password must be at least ' . self::MIN_LENGTH . ' characters long.');
        }

        if (strlen($password) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('Password is too long.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one uppercase letter.');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one lowercase letter.');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one number.');
        }

        if (!preg_match('/[\W_]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one special character.');
        }

        if (in_array(strtolower($password), self::BLACKLIST, true)) {
            throw new InvalidArgumentException('Password is too common and easily guessed.');
        }
    }

    // Hashes a password.
    public static function _hash(string $password): string
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        if ($passwordHash === false) {
            throw new RuntimeException('Unable to secure password.');
        }
        return $passwordHash;
    }

}