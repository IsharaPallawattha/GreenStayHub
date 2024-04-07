<?php
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
global $conn;
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Landlord, UserType::Student);

$requestId = $_GET["id"] ?? null;
$action = $_GET["action"] ?? null;
$advertId = $_GET["advertId"] ?? null;

try {
    if ($requestId) {
        $request = getRequest($requestId, $conn);
        if (!$request) throw new Exception("Request does not exist.");
    }
    if (($action != 'create' || $requestId || !$advertId || $user->getType() !== UserType::Student) &&
        ($action != 'view' || !$requestId || $advertId)) {
        throw new Exception("A broken url was used");
    }
} catch (Exception $e) {
    insertError($_SESSION, $e->getMessage());
    redirectUsingUrlParam($user->getDashboardUrl());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request | GreenStayHub</title>
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
            require "app/pages/request/create.php";
        } elseif ($action == 'view') {
            require "app/pages/request/view.php";
        }
        ?>
    </div>
    
</div>
</body>
</html>
