<?php

require_once __DIR__ . "/UserSkeleton.php";
require_once __DIR__ . "/../connection/connection.php";

class User extends UserSkeleton
{
    public static function save()
    {
        global $pdo;
        // Check if email already exists
        if (self::userExists(self::$email)) {
            return false;
        }
        // Check if all fields are provided
        if (empty(self::$username) || empty(self::$email) || empty(self::$password)) {
            return false;
        }

        // Prepare the SQL query
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);


        $stmt->execute([
            ':username' => self::$username,
            ':email' => self::$email,
            ':password' => password_hash(self::$password, PASSWORD_BCRYPT)
        ]);
        return true;
    }

    // Function to check if a user already exists
    public static function userExists($email)
    {
        global $pdo;
        $sql = "SELECT id,username,email,password FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}