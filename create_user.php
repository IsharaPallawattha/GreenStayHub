<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/user/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";
require_once "app/backend/extractors.php";
require_once "app/backend/inserters.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Admin);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? null;
    $name = $_POST["name"] ?? null;
    $password = $_POST["password"] ?? null;
    $avatar = $_FILES['avatarInput'] ?? null;
    $reference = $_POST['reference'] ?? null;
    $type = $_POST['type'] ?? null;
    try {
        if (!is_null($avatar) && $avatar['error'] === UPLOAD_ERR_OK && is_uploaded_file($avatar['tmp_name']) && $avatar["type"] == "image/png") {
            $thumbnailPath = $avatar['tmp_name'];
        } else {
            throw new Exception("Upload a png file as the the avatar");
        }
        $userType = UserType::from($type);
        if($userType === UserType::Admin) {
            throw new Exception("Admins cannot be created");
        }
        createUser($reference, $username, $password, $name, $userType, $thumbnailPath, $conn);
        insertInfo($_SESSION, "User created successfully");
        redirectUsingUrlParam($user->getDashboardUrl());
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());