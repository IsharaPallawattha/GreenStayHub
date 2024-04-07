<?php
require_once "app/init.php";
require_once "app/backend/user/UserType.php";
global $request, $user;
?>

<div class="container view">
    <div class="title-bar">
        <div class="title">Request #<?php echo $request->getId() ?></div>
        <div class="action-wrapper <?php echo $user->getType() === UserType::Landlord && $request->getStatus() === Status::Pending ? '' : 'hidden' ?>">
            <button class="action">Respond</button>
            <form action="<?php echo BASE_URL ?>process_request.php" method="post">
                <div class="input-container hidden">
                    <label for="request_id">Request id</label>
                    <input type="number" id="request_id" name="request_id" value="<?php echo $request->getId() ?>">
                </div>
                <div class="input-container">
                    <label for="accept-input">
                        <input type="radio" id="accepted" name="status" value="accepted" required>Accept
                    </label>
                    <label for="reject-input">
                        <input type="radio" id="rejected" name="status" value="rejected" required>Reject
                    </label>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="content">
        <div class="text">
            <div class="comment"><?php echo $request->getComment() ?></div>
            <div class="posted-on"><?php echo formatEpoch($request->getPostedOn()) ?></div>
        </div>
    </div>
</div>