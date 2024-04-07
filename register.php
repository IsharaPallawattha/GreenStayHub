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
session_start();

allowOnlyNonUsers(extractUser($_SESSION));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? null;
    $name = $_POST["name"] ?? null;
    $password = $_POST["password"] ?? null;
    $avatar = $_FILES['avatarInput'] ?? null;
    try {
        if (!is_null($avatar) && $avatar['error'] === UPLOAD_ERR_OK && is_uploaded_file($avatar['tmp_name']) && $avatar["type"] == "image/png") {
            $thumbnailPath = $avatar['tmp_name'];
        } else {
            throw new Exception("Upload a png file as the the avatar");
        }
        $user = createUser(null, $username, $password, $name, UserType::Landlord, $thumbnailPath, $conn);
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
    <title>Register for landlord</title>
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
        <h2>Register for landlord</h2>
        <form id="registerForm"
              action="<?php echo buildUrlWithParam(BASE_URL, extractRedirectUrl($_GET), "register.php") ?>"
              method="POST"
              enctype="multipart/form-data">
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <div class="hint" id="usernameHint">Username exceeds 30 characters</div>
            </div>
            <div class="input-container">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <div class="hint" id="nameHint">Name exceeds 255 characters</div>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div class="hint" id="passwordHint">Password must be 8-32 characters and contain at least one letter,
                    one number, and one symbol
                </div>
            </div>
            <div class="input-container">
                <label for="avatarInput">Avatar:</label>
                <input type="file" name="avatarInput" id="avatarInput" accept="image/png" required>
                <img class="avatar-preview" id="avatarPreview"/>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="link-container">Already hava an account? <a href="<?php echo BASE_URL ?>login.php">log in</a></div>
    </div>
</div>

<script src="<?php echo PUBLIC_JS ?>register.js"></script>
</body>
</html>
