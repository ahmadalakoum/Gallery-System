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
        if (empty(self::$title) || empty(self::$description) || empty(self::$image) || empty(self::$tags)) {
            return false;
        }

        //no empty fields =>insert into the database
        $sql = "INSERT INTO photos (title,description,image,tags,user_id) VALUES (:title,:description,:image,:tags,:user_id)";
        $stmt = $pdo->prepare($sql);


        $stmt->execute([
            ':title' => self::$title,
            ':description' => self::$description,
            ':image' => self::$image,
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
        $sql = "SELECT p.*  FROM photos p JOIN users ON p.user_id=users.id ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id, $user_id)
    {
        global $pdo;

        // Check if id or user_id is empty
        if (empty($id) || empty($user_id)) {
            return false;
        }

        $sqlCheck = "SELECT user_id FROM photos WHERE id = :id";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $photo = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if (!$photo || $photo['user_id'] != $user_id) {
            return false;
        }

        $sqlDelete = "DELETE FROM photos WHERE id = :id AND user_id = :user_id";
        $stmtDelete = $pdo->prepare($sqlDelete);

        if ($stmtDelete->execute([':id' => $id, ':user_id' => $user_id])) {
            return true;
        } else {
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

    public static function update($id, $user_id, $fields)
    {
        global $pdo;

        // Ensure photo exists and belongs to the user
        $sqlCheck = "SELECT user_id FROM photos WHERE id = :id";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $photo = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if (!$photo || $photo['user_id'] != $user_id) {
            return false;
        }

        // Prepare dynamic update query
        $setClause = [];
        $params = [':id' => $id];

        foreach ($fields as $key => $value) {
            $setClause[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        if (empty($setClause)) {
            return false;
        }

        $sqlUpdate = "UPDATE photos SET " . implode(', ', $setClause) . " WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        return $stmtUpdate->execute($params);
    }

}


