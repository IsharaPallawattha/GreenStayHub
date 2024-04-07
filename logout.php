<?php
require_once "app/init.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/utilities.php";
require_once "app/backend/validators.php";
session_start();

unset($_SESSION["user"]);
header("Location: " . BASE_URL);
exit();
