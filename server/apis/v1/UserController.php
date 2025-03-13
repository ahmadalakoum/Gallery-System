<?php
require_once __DIR__ . "/../../utils/cors.php";
require_once __DIR__ . "/../../models/User.php";

class UserController
{
    public static function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Data is not sent'
                ]);
                exit();
            }
            //get the data
            $username = trim($data['username']);
            $email = trim($data['email']);
            $password = trim($data['password']);
            //check for data
            if (empty($username) || empty($email) || empty($password)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
                exit();
            }

            User::create($username, $email, $password);
            $registered = User::save();
            if ($registered) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User registered'
                ]);
                exit();
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error during registration'
                ]);
                exit();

            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Wrong request method'
            ]);
            exit();
        }



    }

    public static function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Data is not sent'
                ]);
                exit();
            }
            //get the data
            $email = trim($data['email']);
            $password = trim($data['password']);
            //check for data
            if (empty($email) || empty($password)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
                exit();
            }

            if ($user = User::userExists($email)) {
                if (password_verify($password, $user['password'])) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'user logged in',
                        'id' => $user['id'],
                        'username' => $user['username']
                    ]);
                    exit();
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Invalid Credentials'
                    ]);
                    exit();
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid Credentials'
                ]);
                exit();
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Wrong request method'
            ]);
            exit();
        }

    }
}