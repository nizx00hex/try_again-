<?php
class Check {
            // Checks for duplicate email or username.
    public static function _duplicateAccount(string $email = null, string $username): void
    {
        if (User::exists('username', $username)) {
            throw new RuntimeException('This username is already taken.');
        }

        if (User::exists('email', $email)) {
            throw new RuntimeException('An account with this email already exists.');
        }

    }

}