<?php
require_once "app/init.php";
global $advertId;
?>

<form action="<?php echo BASE_URL ?>create_request.php" method="post">
    <div class="input-container hidden">
        <label for="advert_id">
            advertId
            <input type="number" id="advert_id" name="advert_id" value="<?php echo $advertId ?>" hidden="hidden">
        </label>
    </div>
    <div class="input-container">
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" required></textarea>
    </div>
    <div class="input-container">
        <input type="submit" value="Create Request">
    </div>
</form>