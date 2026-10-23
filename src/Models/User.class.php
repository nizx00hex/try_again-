
<?php

class User
{
    public static function create($firstname, $secondname, $username, $email, $password) {
        $db = Database::connect();

        $sql = "INSERT INTO users (firstname, secondname, username, email, password, created_at, status, is_verified) VALUES (:firstname, :secondname, :username, :email, :password, :created_at, :status, :is_verified)";

        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([
                ':firstname'  => $firstname,
                ':secondname' => $secondname,
                ':username'   => $username,
                ':email'      => $email,
                ':password'   => $password,
                ':created_at' => date('Y-m-d H:i:s'),
                ':status'     => 'active',
                ':is_verified' => 0
            ]);
        } catch (PDOException $e) {
            // MySQL duplicate key error
            if ($e->getCode() === '23000') {
                throw new RuntimeException(
                    'Email or username already exists.',
                    0,
                    $e
                );
            }
            throw $e;
        }
        return (int) $db->lastInsertId();
    }

    public static function getUsers($id)
    {
        $db = Database::connect();

        $sql = "SELECT id, firstname, secondname, username,
                       email, created_at, status, is_verified
                FROM users
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function exists(string $field, string $value): bool
    {
        $allowedFields = ['username', 'email'];

        if (!in_array($field, $allowedFields, true)) {
            throw new InvalidArgumentException('Invalid field.');
        }

        $db = Database::connect();

        $value = trim($value);

        if ($field === 'email') {
            $value = strtolower($value);
        }

        $sql = "SELECT 1 FROM users WHERE {$field} = :value LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute(['value' => $value]);

        return $stmt->fetchColumn() !== false;
    }

    public static function _findByUsername($username) {
        $db = Database::connect();

        $username = trim($username);

        $sql = "SELECT id, username, email, password
                FROM users
                WHERE username = :username
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $username
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
