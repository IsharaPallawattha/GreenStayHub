<?php
require_once "app/init.php";
global $user;
?>

<div class="topbar">
    <a href="<?php echo BASE_URL ?>"><img class="logo" alt="logo" src="<?php echo PUBLIC_ASSETS ?>logo/logo.png"></a>
    <div class="avatar-menu">
        <div class="avatar">
            <img alt="avatar"
                 src="<?php echo $user ? $user->getAvatar()->getDataUri() : PUBLIC_ASSETS . 'webp/default-avatar.webp' ?>">
        </div>
        <div class="drawer">
            <a class="item" href="<?php echo BASE_URL ?>logout.php">Logout</a>
        </div>
    </div>
</div>
