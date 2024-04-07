<?php
require_once "app/init.php";
require_once "app/backend/request/Request.php";

/* @var Request $request */
global $request;
?>

<div class="content">
    <div class="text">
        <div class="title">
            Request
            <a href="request.php?action=view&id=<?php echo $request->getId() ?>">#<?php echo $request->getId() ?></a>
            For
            <a href="<?php echo BASE_URL ?>advertisement.php?action=view&id=<?php echo $request->getAdvertisement()->getId() ?>"><?php echo $request->getAdvertisement()->getTitle() ?></a>
        </div>
        <div class="description"><?php echo $request->getComment() ?></div>
        <div class="posted-on"><?php echo formatEpoch($request->getPostedOn()) ?></div>
        <div class="status <?php echo $request->getStatus()->value ?>"><?php echo $request->getStatus()->name ?></div>
    </div>
</div>