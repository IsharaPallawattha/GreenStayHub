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
require_once "app/backend/extractors.php";
require_once "app/backend/validators.php";
require_once "app/backend/utilities.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Admin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | GreenStayHub</title>
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
                <div class="title">Articles</div>
                <a class="action" href="<?php echo BASE_URL ?>article.php?action=create">New</a>
            </div>
            <div class="empty-display">No articles to display</div>
            <?php
            foreach (getAllArticles($conn) as $article) {
                include "app/frontend/ui/article.php";
            }
            ?>
        </div>
        <div class="container">
            <div class="title-bar">
                <div class="title">Users</div>
                <a class="action" href="<?php echo BASE_URL ?>user.php?action=create">New</a>
            </div>
        </div>
    </div>
    
</div>
</body>
</html>
