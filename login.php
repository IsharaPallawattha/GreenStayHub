<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/user/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";
require_once "app/backend/extractors.php";
require_once "app/backend/inserters.php";
require_once "app/backend/validators.php";
session_start();

allowOnlyNonUsers(extractUser($_SESSION));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? null;
    $password = $_POST["password"] ?? null;
    try {
        $user = getUser($username, $password, $conn);
        $_SESSION["user"] = $user;
        redirectUsingUrlParam($user->getDashboardUrl());
    } catch (Exception $e) {
        insertError($_SESSION, $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log in</title>
    <?php include "app/frontend/includes/head.php" ?>
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>statusbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>app.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>access.css">
</head>
<body>
<?php include "app/frontend/ui/alerts.php" ?>
<div class="access-container">
    <div class="access">
        <div class="logo-container">
            <a href="<?php echo BASE_URL ?>">
                <img src="<?php echo PUBLIC_ASSETS ?>logo/logo.png" alt="GreenStayHub Logo"/>
            </a>
        </div>
        <h2>Log in</h2>
        <form id="loginForm" action="<?php echo buildUrlWithParam(BASE_URL, extractRedirectUrl($_GET), "login.php") ?>"
              method="POST">
            <div class="input-container" styles="text-align:center">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Log in</button>
        </form>
        <div class="link-container">Don't hava an account? <a href="<?php echo buildUrlWithParam(BASE_URL, extractRedirectUrl($_GET), "register.php") ?>">register as a landlord</a> or <a>contact
                admin</a></div>
    </div>
</div>

</body>
</html>
