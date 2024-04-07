<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/advertisement/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";
require_once "app/backend/extractors.php";
require_once "app/backend/inserters.php";
require_once "app/backend/validators.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Landlord);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $advertisementId = $_POST["id"] ?? null;
    $advertisement = getAdvertisement($advertisementId, $conn);
    $title = $_POST["title"] ?? null;
    $description = $_POST["description"] ?? null;
    $thumbnail = $_FILES["thumbnail"] ?? null;
    $pictures = $_FILES["pictures"] ?? null;
    try {
        if (is_null($advertisement)) {
            throw new Exception("Advertisement not found");
        }
        if (!is_null($thumbnail) && $thumbnail['error'] === UPLOAD_ERR_OK && is_uploaded_file($thumbnail['tmp_name'])) {
            $thumbnailPath = $thumbnail['tmp_name'];
        } else {
            $thumbnailPath = null;
        }
        if (!is_null($pictures) && $pictures['error'][0] === UPLOAD_ERR_OK && is_uploaded_file($pictures['tmp_name'][0])) {
            $picturePaths = $pictures['tmp_name'];
        } else {
            $picturePaths = null;
        }
        $advertisement->update($title, $description, $thumbnailPath, $picturePaths, $conn);
        insertInfo($_SESSION, "Advertisement updated successfully");
        redirectUsingUrlParam($user->getDashboardUrl());
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
redirectUsingUrlParam($user->getDashboardUrl());
