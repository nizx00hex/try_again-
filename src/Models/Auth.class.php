<?php

require_once 'Validate.class.php';
require_once 'Password.class.php';
require_once 'Check.class.php';
require_once 'User.class.php';
require_once 'Database.class.php';


class Auth {

    public static function signup($firstname, $secondname, $username, $email, $password, $confirmPassword){
        $fullname = trim($firstname);
        $secondname = trim($secondname);
        $username = trim($username);
        $email    = strtolower(trim($email));


        Validate::_firstname($firstname);
        Validate::_secondname($secondname);
        Validate::_username($username);
        Validate::_email($email);
        Validate::_password($password, $confirmPassword);

        Password::validate($password);
        Check::_duplicateAccount($email, $username);

        $passwordHash = Password::_hash($password);
        $uid = User::create($firstname, $secondname, $username, $email, $passwordHash);
        return $uid;
    }

    public static function login($username, $password) {

        Validate::_username($username);
        Validate::_password($password);

        Password::validate($password);

        $user = User::findByUsername($username);

        if ($user === false) {
            throw new RuntimeException('Invalid username or password.');
        }

        if (!password_verify($password, $user['password'])) {
            throw new RuntimeException('Invalid username or password.');
        }
    }


}

Auth::login('nisath', 'password1#2A');