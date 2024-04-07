<?php
require_once "app/init.php";
$errors = $_SESSION["errors"] ?? array();
unset($_SESSION["errors"]);
$warnings = $_SESSION["warnings"] ?? array();
unset($_SESSION["warnings"]);
$infos = $_SESSION["infos"] ?? array();
unset($_SESSION["infos"]);
?>

<div class="alerts">
    <?php
    foreach ($errors as $error) {
        echo "<div class='alert error'>$error<button class='close-btn'><i class='fa-solid fa-xmark'></i></button></div>";
    }
    foreach ($warnings as $warning) {
        echo "<div class='alert warning'>$warning<button class='close-btn'><i class='fa-solid fa-xmark'></i></button></div>";
    }
    foreach ($infos as $info) {
        echo "<div class='alert info'>$info<button class='close-btn'><i class='fa-solid fa-xmark'></i></button></div>";
    }
    ?>
</div>
<script src="<?php echo PUBLIC_JS ?>alerts.js"></script>
