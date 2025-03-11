<?php

class UserSkeleton
{
    public static $username;
    public static $email;
    public static $password;

    //function to create a user
    public static function create($username, $email, $password)
    {
        self::$username = $username;
        self::$email = $email;
        self::$password = $password;
    }
}