<?php
require_once "app/init.php";
require_once "app/backend/user/UserType.php";
global $advertisement, $user;
?>

<div class="container view">
    <div class="title-bar">
        <div class="title"><?php echo $advertisement->getTitle() ?></div>
        <a class="action <?php echo $user->getType() === UserType::Landlord ? '' : 'hidden' ?>"
           href="<?php echo BASE_URL ?>advertisement.php?action=edit&id=<?php echo $advertisement->getId() ?>">Edit</a>
        <a class="action <?php echo $user->getType() === UserType::Student ? '' : 'hidden' ?>"
           href="<?php echo BASE_URL ?>request.php?action=create&advertId=<?php echo $advertisement->getId() ?>">Request</a>
        <div class="action-wrapper <?php echo $user->getType() === UserType::Warden && $advertisement->getStatus() === Status::Pending ? '' : 'hidden' ?>">
            <button class="action">Process</button>
            <form action="<?php echo BASE_URL ?>process_advertisement.php" method="post">
                <div class="input-container hidden">
                    <label for="advertisement_id">Advertisement id</label>
                    <input type="number" id="advertisement_id" name="advertisement_id"
                           value="<?php echo $advertisement->getId() ?>" hidden="hidden">
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
        <img class="thumbnail" src="<?php echo $advertisement->getThumbnail()->getDataUri() ?>" alt="article thumbnail"/>
        <div class="pictures swiper-container">
            <div class="swiper-wrapper">
                <?php
                foreach ($advertisement->getPictures() as $picture) {
                    echo '<div class="swiper-slide"><img src="' . $picture->getDataUri() . '" alt="advertisement picture" /></div>';
                }
                ?>
            </div>
            <div class="swiper-plugin-pagination"></div>
        </div>
        <div class="text">
            <div class="description"><?php echo $advertisement->getDescription() ?></div>
            <div class="last-edited"><?php echo $advertisement->getLastEdited() ?></div>
        </div>
    </div>
</div>