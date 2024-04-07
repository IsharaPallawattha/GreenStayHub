<?php
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
global $conn;
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Student, UserType::Admin);

$articleId = $_GET["id"] ?? null;
$action = $_GET["action"] ?? null;
try {
    if ($articleId) {
        $article = getArticle($articleId, $conn);
        if (!$article) throw new Exception("Article does not exist.");
    }
    if (($action != 'create' || $articleId || $user->getType() !== UserType::Admin) &&
        ($action != 'edit' || !$articleId || $user->getType() !== UserType::Admin) &&
        ($action != 'view' || !$articleId)) {
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
    <title>Article | GreenStayHub</title>
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
            require "app/pages/article/create.php";
        } elseif ($action == 'edit') {
            require "app/pages/article/edit.php";
        } elseif ($action == 'view') {
            require "app/pages/article/view.php";
        }
        ?>
    </div>
    
</div>
</body>
</html>
