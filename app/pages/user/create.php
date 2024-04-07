<?php
require_once "app/init.php";
?>

<form action="<?php echo BASE_URL ?>create_user.php" method="post" enctype="multipart/form-data">
    <div class="input-container">
        <label for="type">User Type:</label>
        <select id="type" name="type" required>
            <?php foreach (UserType::cases() as $type) {
                if ($type === UserType::Admin) continue ?>
                <option value="<?php echo $type->value ?>"><?php echo $type->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="input-container">
        <label for="reference">Reference:</label>
        <input type="number" id="reference" name="reference">
    </div>
    <div class="input-container">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-container">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="input-container">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="input-container">
        <label for="avatarInput">Avatar:</label>
        <input type="file" name="avatarInput" id="avatarInput" accept="image/png" required>
        <img id="avatarPreview"/>
    </div>
    <div class="input-container">
        <input type="submit" value="Create User">
    </div>
</form>
<script src="<?php echo PUBLIC_JS ?>create_advertisement.js"></script>