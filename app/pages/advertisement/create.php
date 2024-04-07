<?php
require_once "app/init.php";
?>

<form action="<?php echo BASE_URL ?>create_advertisement.php" method="post" enctype="multipart/form-data">
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
        <label for="pictures">Pictures:</label>
        <input type="file" id="pictures" name="pictures[]" multiple required>
    </div>
    <div class="input-container">
        <div id="map-input" class="map-input" style="height: 40em; width: 40em;"></div>
        <label for="latitude">
            <input type="text" id="latitude" name="latitude" required hidden="hidden">
        </label>
        <label for="longitude">
            <input type="text" id="longitude" name="longitude" required hidden="hidden">
        </label>
        <button id="update-map" type="button">Current location</button>
    </div>
    <div class="input-container">
        <input type="submit" value="Create Advertisement">
    </div>
</form>
<script src="<?php echo PUBLIC_JS ?>create_advertisement.js"></script>