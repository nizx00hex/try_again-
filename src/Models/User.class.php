
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

    // public static function _findByUsername($username) {
    //     $db = Database::connect();

    //     $username = trim($username);

    //     $sql = "SELECT id, username, email, password
    //             FROM users
    //             WHERE username = :username
    //             LIMIT 1";

    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([
    //         ':username' => $username
    //     ]);

    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }


    public static function _find(string $value, ?string $field = null): ?array
    {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $columns = 'id, firstname, secondname, username, email, password, created_at, updated_at, status, is_verified';
        
        // Login mode: email OR username
        if ($field === null) {
            
            if (str_contains($value, '@')) {
                $value = mb_strtolower($value);
            }
            $sql  = "SELECT {$columns} FROM users WHERE email = :email OR username = :username LIMIT 1";
            $args = [':email' => $value, ':username' => $value];

        } else {
            // Specific field mode
            if (!in_array($field, ['username', 'email'], true)) {
                throw new InvalidArgumentException('Invalid field.');
            }

            if ($field === 'email') {
                $value = mb_strtolower($value);
            }
            
            $sql  = "SELECT {$columns} FROM users WHERE {$field} = :value LIMIT 1";
            $args = [':value' => $value];
        }

        $stmt = Database::connect()->prepare($sql);
        $stmt->execute($args);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
