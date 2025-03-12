<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../../models/Photo.php";
require_once __DIR__ . "/../../getBearer.php";
class PhotoController
{
    public static function insertPhoto()
    {
        $user_id = getBearerToken();
        if (empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit();
        }

        $image = trim($_POST['image']);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $tags = trim($_POST['tags']);

        if (empty($title) || empty($description) || empty($tags) || empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
            exit();
        }


        Photo::create($title, $description, $image, $tags, $user_id);
        $is_saved = Photo::save();

        if ($is_saved) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Photo uploaded successfully'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error during upload'
            ]);
            exit();
        }
    }
    public static function getPhoto()
    {
        $user_id = getBearerToken();
        if (empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit();
        }
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'id not provided'
            ]);
            exit();
        }
        $photoID = $_GET['id'];
        $photo = Photo::getPhoto($photoID);
        if (!empty($photo)) {
            echo json_encode([
                'status' => 'success',
                'photo' => $photo
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'image not found'
            ]);
            exit();
        }
    }
    public static function getPhotos()
    {
        $user_id = getBearerToken();
        if (empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit();
        }
        $photos = Photo::all();
        if (!empty($photos)) {
            echo json_encode([
                'status' => 'success',
                'photos' => $photos
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No available Images'
            ]);
            exit();
        }

    }
    public static function deletePhoto()
    {
        $user_id = getBearerToken();
        if (empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            exit();
        }
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'id not provided'
            ]);
            exit();
        }
        $id = $_GET['id'];
        $deleted = Photo::delete($id, $user_id);
        if ($deleted) {
            echo json_encode([
                'status' => 'success',
                'message' => "photo is deleted"
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'could not delete photo'
            ]);
            exit();
        }
    }
    public static function search()
    {
        $userID = getBearerToken();
        if (!$userID) {
            echo json_encode([
                'status' => 'error',
                "message" => "Unauthorized"
            ]);
            exit();
        }
        if (!isset($_GET['search'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'no search parameter provided'
            ]);
            exit();
        }
        //get the search param
        $searchTerm = trim($_GET['search']);

        if (empty($searchTerm)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'search term cannot be empty'
            ]);
            exit();
        }
        $photos = Photo::searchPhotos($searchTerm);
        if (empty($photos)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No Photos Found'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'success',
                'photos' => $photos
            ]);
            exit();
        }
    }
}