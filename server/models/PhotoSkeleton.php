<?php

class PhotoSkeleton
{
    public static $title;
    public static $description;
    public static $image;
    public static $tags;
    public static $user_id;

    public static function create($title, $description, $image, $tags, $user_id)
    {
        self::$title = $title;
        self::$description = $description;
        self::$image = $image;
        self::$tags = $tags;
        self::$user_id = $user_id;
    }
}