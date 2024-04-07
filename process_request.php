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

allowOnlyUserTypes($user, UserType::Landlord);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reqId = $_POST["request_id"] ?? null;
    $status = $_POST["status"] ?? null;

    try {
        if (!is_null($reqId) && !is_null($status)) {
            getRequest($reqId, $conn)->setStatus(
                $conn,
                Status::from(strtolower($status))
            );
            insertInfo($_SESSION, "Request processed successfully");
            redirectUsingUrlParam($user->getDashboardUrl());
        } else {
            throw new Exception("Fill in all the fields");
        }
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());
