<?php

class PhotoSkeleton
{
    public static $title;
    public static $description;
    public static $image_path;
    public static $tags;
    public static $user_id;

    public static function create($title, $description, $image_path, $tags, $user_id)
    {
        self::$title = $title;
        self::$description = $description;
        self::$image_path = $image_path;
        self::$tags = $tags;
        self::$user_id = $user_id;
    }
}