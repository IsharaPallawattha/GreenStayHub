<?php
require_once "app/init.php";
?>

<form action="<?php echo BASE_URL ?>create_article.php" method="post" enctype="multipart/form-data">
    <div class="input-container">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="input-container">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div class="input-container">
        <label for="thumbnail">Thumbnail:</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/png" required>
    </div>
    <div class="input-container">
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
    </div>
    <div class="input-container">
        <input type="submit" value="Create Article">
    </div>
</form>