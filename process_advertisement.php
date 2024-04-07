<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/request/helpers.php";
require_once "app/backend/inserters.php";
require_once "app/backend/helpers.php";
require_once "app/backend/extractors.php";
require_once "app/backend/validators.php";
require_once "app/backend/auth.php";

session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Warden);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $advertId = $_POST["advertisement_id"] ?? null;
    $status = $_POST["status"] ?? null;

    try {
        if (!is_null($advertId) && !is_null($status)) {
            getAdvertisement($advertId, $conn)->setStatus(
                $conn,
                Status::from(strtolower($status))
            );
            insertInfo($_SESSION, "Advertisement processed successfully");
            redirectUsingUrlParam($user->getDashboardUrl());
        } else {
            throw new Exception("Fill in all the fields");
        }
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());
