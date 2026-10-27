<?php
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
        User::_find('nisathnisath1@gmail.com0');


        $passwordHash = Password::_hash($password);
        $uid = User::create($firstname, $secondname, $username, $email, $passwordHash);
        return $uid;
    }

    public static function login($identifier, $password) {

        /**
         * 1. validate the identifier.
         * 2. check identifier already exists
         * 3. check if ther user verfied or not.
         *      if not verfied set user id in session then create otp then send to user email now redirect to otp page
         *      verify the otp redirect to login page now login normaly
         * 4. verfiy the password
         * 5. if: enable 2FA got to otp verify page, if: verifed set session and redirect to dashboard page.
         * 6. else: verfiy the password, ?success redirect to dashboard.
         */


        try {
            Validate::_identifier($identifier);
            $user = User::_find($identifier);
            if($user['is_verified'] === 1) {
                echo "Please verify your account";
            }
            Password::_validate($password);


        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    //     // Authenticates a user with email/username and password.
    // public static function login(string $identifier, string $password): array
    // {
    //     $identifier = trim($identifier);
    //     if ($identifier === '' || $password === '') {
    //         throw new RuntimeException('Enter the correct email or password.');
    //     }
    //     $user = self::findByIdentifier($identifier);
    //     if ($user === null) {
    //         throw new RuntimeException('Enter the correct email or password.');
    //     }
    //     if (!self::verifyPassword($password, (string) $user['password'])) {
    //         throw new RuntimeException('Enter the correct email or password.');
    //     }
    //     if ((int) $user['is_verified'] !== 1) {
    //         Session::set('pending_verification_user_id', (int) $user['id']);
    //         try {
    //             if (empty($user['otp_hash']) || Otp::canResend((int) $user['id'])) {
    //                 Otp::createForUser((int) $user['id']);
    //             }
    //         } catch (Throwable $e) {
    //             error_log('OTP generation during unverified login: ' . $e->getMessage());
    //         }
    //         Session::flash('error', 'Your account is not verified. Please verify your email.');
    //         header('Location: otp-verify.php');
    //         exit;
    //     }
    //     if (password_needs_rehash((string) $user['password'], PASSWORD_DEFAULT)) {
    //         self::rehashPassword((int) $user['id'], $password);
    //     }
    //     unset($user['password']);
    //     return $user;
    // }


}

// Auth::login('nisath', 'password1#2A');