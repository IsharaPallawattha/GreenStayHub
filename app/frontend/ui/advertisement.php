<?php
require_once "app/init.php";
require_once "app/backend/advertisement/Advertisement.php";

/* @var Advertisement $advertisement */
global $advertisement, $user;
$thumbnailSrc = $advertisement->getThumbnail()->getDataUri();
$lastEdited = formatEpoch($advertisement->getLastEdited());
?>

<div class="content">
    <img class="thumbnail" alt="thumbnail" src="<?php echo $thumbnailSrc ?>"/>
    <div class="text">
        <a class="title" href="<?php echo BASE_URL . 'advertisement.php?action=view&id=' . $advertisement->getId() ?>">
            <?php echo $advertisement->getTitle() ?>
        </a>
        <?php if ($user->getType() === UserType::Landlord || $user->getType() === UserType::Warden) { ?>
            <div class="status <?php echo $advertisement->getStatus()->value ?>"><?php echo $advertisement->getStatus()->name ?></div>
        <?php } ?>
        <div class="description">
            <?php echo $advertisement->getDescription() ?>
        </div>
        <div class="last-edited">
            <?php echo $lastEdited ?>
        </div>
    </div>
</div>