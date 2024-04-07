<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/article/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";
require_once "app/backend/extractors.php";
require_once "app/backend/inserters.php";
require_once "app/backend/validators.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Admin);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"] ?? null;
    $description = $_POST["description"] ?? null;
    $thumbnail = $_FILES["thumbnail"] ?? null;
    $content = $_POST["content"] ?? null;
    try {
        if (!is_null($thumbnail) && $thumbnail['error'] === UPLOAD_ERR_OK && is_uploaded_file($thumbnail['tmp_name'])) {
            $thumbnailPath = $thumbnail['tmp_name'];
        } else {
            throw new Exception("Upload a png file as the the avatar");
        }
        createArticle($title, $description, $thumbnailPath, $content, $conn);
        insertInfo($_SESSION, "Article created successfully");
        redirectUsingUrlParam($user->getDashboardUrl());
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());
