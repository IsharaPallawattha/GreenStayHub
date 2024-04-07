<?php
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
global $conn;
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Landlord, UserType::Student, UserType::Warden);

$advertId = $_GET["id"] ?? null;
$action = $_GET["action"] ?? null;
try {
    if ($advertId) {
        $advertisement = getAdvertisement($advertId, $conn);
        if (!$advertisement) throw new Exception("Advertisement does not exist.");
    }
    if (($action != 'create' || $advertId || $user->getType() !== UserType::Landlord) &&
        ($action != 'edit' || !$advertId || $user->getType() !== UserType::Landlord) &&
        ($action != 'view' || !$advertId)) {
        throw new Exception("A bad url was used");
    }
} catch (Exception $e) {
    insertError($_SESSION, $e->getMessage());
    redirectUsingUrlParam($user->getDashboardUrl());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Advertisement | GreenStayHub</title>
    <?php include "app/frontend/includes/head.php" ?>
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>topbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>statusbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>app.css">
</head>
<body>
<div class="app-wrapper">
    <?php
    include "app/frontend/ui/topbar.php";
    include "app/frontend/ui/alerts.php";
    ?>
    <div class="app">
        <?php
        if ($action == 'create') {
            require "app/pages/advertisement/create.php";
        } elseif ($action == 'edit') {
            require "app/pages/advertisement/edit.php";
        } elseif ($action == 'view') {
            require "app/pages/advertisement/view.php";
        }
        ?>
    </div>
    
</div>
</body>
</html>
