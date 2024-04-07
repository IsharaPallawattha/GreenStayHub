<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/advertisement/helpers.php";
require_once "app/backend/request/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/extractors.php";
require_once "app/backend/validators.php";
require_once "app/backend/utilities.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Landlord);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landlord | GreenStayHub</title>
    <?php include "app/frontend/includes/head.php" ?>
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>topbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>statusbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>app.css">
</head>
<body>
<div class="app-wrapper">
    <?php include "app/frontend/ui/topbar.php"; ?>
    <?php include "app/frontend/ui/alerts.php" ?>
    <div class="app">
        <div class="container">
            <div class="title-bar">
                <div class="title">Advertisements</div>
                <a class="action" href="<?php echo BASE_URL ?>advertisement.php?action=create">New</a>
            </div>
            <div class="empty-display">No advertisements to display</div>
            <?php
            foreach (getLandlordAdvertisements($user->getId(), $conn) as $advertisement) {
                include "app/frontend/ui/advertisement.php";
            }
            ?>
        </div>
        <div class="container">
            <div class="title-bar">
                <div class="title">Requests</div>
            </div>
            <div class="empty-display">No requests to display</div>
            <?php
            foreach (getRequestsForLandlord($user->getId(), $conn) as $request) {
                include "app/frontend/ui/request.php";
            }
            ?>
        </div>
    </div>
    
</div>
</body>
</html>
