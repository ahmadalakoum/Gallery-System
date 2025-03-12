<?php
require_once __DIR__ . "/PhotoSkeleton.php";
require_once __DIR__ . "/User.php";
require_once __DIR__ . "/../connection/connection.php";
class Photo extends PhotoSkeleton
{
    //function to insert the photo in the database
    public static function save()
    {
        global $pdo;

        //check for empty fields
        if (empty(self::$title) || empty(self::$description) || empty(self::$image_path) || empty(self::$tags)) {
            return false;
        }

        //no empty fields =>insert into the database
        $sql = "INSERT INTO photos (title,description,image_path,tags,user_id) VALUES (:title,:description,:image_path,:tags,:user_id)";
        $stmt = $pdo->prepare($sql);


        $stmt->execute([
            ':title' => self::$title,
            ':description' => self::$description,
            ':image_path' => self::$image_path,
            ':tags' => self::$tags,
            ':user_id' => self::$user_id
        ]);
        return true;
    }
    public static function getPhoto($id)
    {
        global $pdo;
        if (empty($id)) {
            return false;
        }
        $sql = "SELECT * FROM photos WHERE id =:id
        JOIN users ON photos.user_id=users.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    public static function all()
    {
        global $pdo;
        $sql = "SELECT * FROM photos JOIN users ON photos.user_id=users.id ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id, $user_id)
    {
        global $pdo;

        // Check if id or user_id is empty
        if (empty($id) || empty($user_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Missing ID or User ID'
            ]);
            exit();
        }

        $sqlCheck = "SELECT user_id FROM photos WHERE id = :id";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $photo = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if (!$photo || $photo['user_id'] != $user_id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized or photo not found'
            ]);
            exit();
        }

        // SQL to delete the photo
        $sqlDelete = "DELETE FROM photos WHERE id = :id AND user_id = :user_id";
        $stmtDelete = $pdo->prepare($sqlDelete);

        // Execute the deletion query
        if ($stmtDelete->execute([':id' => $id, ':user_id' => $user_id])) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Photo deleted successfully'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete photo'
            ]);
            exit();
        }
    }

}