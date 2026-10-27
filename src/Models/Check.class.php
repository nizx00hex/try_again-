<?php
class Check
{
    public static function _duplicateAccount(string $email, string $username): void
    {
        if (User::_find($username, 'username') !== null) {
            throw new RuntimeException('This username is already taken.');
        }

        if (User::_find($email, 'email') !== null) {
            throw new RuntimeException('An account with this email already exists.');
        }
    }
}