<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/request/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";
require_once "app/backend/extractors.php";
require_once "app/backend/inserters.php";
require_once "app/backend/validators.php";

session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Student);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $advertId = $_POST["advert_id"] ?? null;
    $comment = $_POST["comment"] ?? null;
    try {
        if (!is_null($advertId) && !is_null($comment)) {
            createRequest($advertId, $user->getId(), $comment, $conn);
            insertInfo($_SESSION, "Request created successfully");
            redirectUsingUrlParam($user->getDashboardUrl());
        } else {
            throw new Exception("Fill in all the fields");
        }
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());