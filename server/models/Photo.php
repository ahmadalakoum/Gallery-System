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
        $sql = "SELECT photos.*, users.username FROM photos 
        JOIN users ON photos.user_id = users.id 
        WHERE photos.id = :id";
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
            return false;
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
            return false;
        }

        $sqlDelete = "DELETE FROM photos WHERE id = :id AND user_id = :user_id";
        $stmtDelete = $pdo->prepare($sqlDelete);

        if ($stmtDelete->execute([':id' => $id, ':user_id' => $user_id])) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Photo deleted successfully'
            ]);
            return true;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete photo'
            ]);
            return false;
        }
    }
    public static function searchPhotos($searchTerm)
    {
        global $pdo;

        $sql = "SELECT *,u.username FROM photos p JOIN users u ON u.id=p.user_id WHERE title LIKE :searchTerm OR description LIKE :searchTerm OR tags LIKE :searchTerm";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([':searchTerm' => "%" . $searchTerm . "%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);


    }
    // public static function update($id, $fields, $user_id)
    // {
    //     global $pdo;

    //     if (empty($id) || empty($user_id)) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Missing ID or User ID'
    //         ];
    //     }

    //     // Check if the user owns the photo
    //     $sqlCheck = "SELECT * FROM photos WHERE id = :id";
    //     $stmtCheck = $pdo->prepare($sqlCheck);
    //     $stmtCheck->execute([':id' => $id]);
    //     $photo = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    //     if (!$photo || $photo['user_id'] != $user_id) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Unauthorized or photo not found'
    //         ];
    //     }

    //     // Prepare dynamic SQL query based on provided fields
    //     $updateFields = [];
    //     $params = [':id' => $id, ':user_id' => $user_id];

    //     foreach ($fields as $key => $value) {
    //         if (!empty($value)) {  // Only update non-empty fields
    //             $updateFields[] = "$key = :$key";
    //             $params[":$key"] = $value;
    //         }
    //     }

    //     if (empty($updateFields)) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'No fields provided for update'
    //         ];
    //     }

    //     $sqlUpdate = "UPDATE photos SET " . implode(", ", $updateFields) . " WHERE id = :id AND user_id = :user_id";
    //     $stmtUpdate = $pdo->prepare($sqlUpdate);
    //     $updated = $stmtUpdate->execute($params);

    //     return $updated
    //         ? ['status' => 'success', 'message' => 'Photo updated successfully']
    //         : ['status' => 'error', 'message' => 'Failed to update photo'];
    // }

}


