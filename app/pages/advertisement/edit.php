<?php
global $advertId;
require_once "app/init.php";
?>

<form action="<?php echo BASE_URL ?>edit_advertisement.php" method="post" enctype="multipart/form-data">
    <div class="input-container">
        <label for="id">Id:</label>
        <input type="number" id="id" name="id" value="<?php echo $advertId ?>" hidden="hidden">
    </div>
    <div class="input-container">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
    </div>
    <div class="input-container">
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div class="input-container">
        <label for="thumbnail">Thumbnail:</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/png">
    </div>
    <div class="input-container">
        <label for="pictures">Pictures:</label>
        <input type="file" id="pictures" name="pictures[]" multiple>
    </div>
    <div class="input-container">
        <input id="submitBtn" type="submit" value="Edit Advertisement" disabled>
    </div>
</form>

<script>
    const inputs = document.querySelectorAll('input[type="text"], input[type="file"], textarea');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (input.value.trim() !== '') {
                input.classList.add('filled');
            } else {
                input.classList.remove('filled');
            }
            checkInputs();
        });
    });

    function checkInputs() {
        const filledInputs = document.querySelectorAll('.filled').length !== 0;
        document.getElementById('submitBtn').disabled = !filledInputs;
    }
</script>
