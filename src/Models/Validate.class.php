<?php
class Validate {
    
    // private const MIN_PASSWORD_LENGTH = 8;
    private const USERNAME_PATTERN = '/^[A-Za-z0-9_]{3,50}$/';
    // private const MAX_NAME_LENGTH = 10;
    // private const MIN_NAME_LENGTH = 4;
    private const MAX_EMAIL_LENGTH = 254;
    // private const USERNAME_PATTERN = '/^[A-Za-z0-9_]{3,50}$/';

    // private const MAX_EMAIL_LENGTH = 255;

    // // Validates Firstname.
    // public static function _firstname(string $firstname): void
    // {
    //     if ($firstname === '') {
    //         throw new InvalidArgumentException('First name is required.');
    //     }
    //     // if (mb_strlen($firstname) < self::MAX_NAME_LENGTH) {
    //     //     throw new InvalidArgumentException('First name is too short.');
    //     // }
    //     // if (mb_strlen($firstname) > self::MIN_NAME_LENGTH) {
    //     //     throw new InvalidArgumentException('First name is too long.');
    //     // }
    // }
    // // Validates Secondname.
    // public static function _secondname(string $secondname): void
    // {
    //     if ($secondname === '') {
    //         throw new InvalidArgumentException('Second name is required.');
    //     }
    //     // if (mb_strlen($secondname) < self::MAX_NAME_LENGTH) {
    //     //     throw new InvalidArgumentException('Second name is too short.');
    //     // }
    //     // if (mb_strlen($secondname) > self::MAX_NAME_LENGTH) {
    //     //     throw new InvalidArgumentException('Second name is too long.');
    //     // }
    // }


    // // Validates username.
    // public static function _username(string $username): void
    // {
    //     if ($username === '') {
    //         throw new InvalidArgumentException('Username is required.');
    //     }
    //     if (!preg_match(self::USERNAME_PATTERN, $username)) {
    //         throw new InvalidArgumentException(
    //             'Username must be 3-50 characters and contain only letters, numbers and underscores.'
    //         );
    //     }
    // }

    // // Validates email.
    // public static function _email(string $email): void
    // {
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         throw new InvalidArgumentException('Enter a valid email address.');
    //     }
    //     if (mb_strlen($email) > self::MAX_EMAIL_LENGTH) {
    //         throw new InvalidArgumentException('Email address is too long.');
    //     }
    // }

    // // Validates password.
    // public static function _password(string $password, string $confirmPassword = null): void
    // {
    //     if ($password === '') {
    //         throw new InvalidArgumentException('Password is required.');
    //     }
    //     if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
    //         throw new InvalidArgumentException(
    //             'Password must contain at least ' . self::MIN_PASSWORD_LENGTH . ' characters.'
    //         );
    //     }
    //     if($confirmPassword !== null) {
    //         if ($password !== $confirmPassword) {
    //             throw new InvalidArgumentException('Passwords do not match.');
    //         }
    //     }
    // }

    public static function _identifier(string $identifier): string
    {
        $identifier = trim($identifier);
        $isEmail = str_contains($identifier, '@');
        if ($isEmail) {
            if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Enter a valid email address.');
            }
            if (mb_strlen($identifier) > self::MAX_EMAIL_LENGTH) {
                throw new InvalidArgumentException('Email address is too long.');
            }
        } else {
            if ($identifier === '') {
                throw new InvalidArgumentException('Username is required.');
            }
            if (!preg_match(self::USERNAME_PATTERN, $identifier)) {
                throw new InvalidArgumentException(
                    'Username must be 3-50 characters and contain only letters, numbers and underscores.'
                );
            }
        }

        return $identifier;
    }
}