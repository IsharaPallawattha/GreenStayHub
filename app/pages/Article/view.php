<?php
require_once "app/init.php";
require_once "app/backend/user/UserType.php";
global $article, $user;
?>

<div class="container view">
    <div class="title-bar">
        <div class="title"><?php echo $article->getTitle() ?></div>
        <a class="action <?php echo $user->getType() === UserType::Admin ? '' : 'hidden' ?>"
           href="<?php echo BASE_URL ?>article.php?action=edit&id=<?php echo $article->getId() ?>">Edit</a>
    </div>
    <div class="content">
        <img class="thumbnail" src="<?php echo $article->getThumbnail()->getDataUri() ?>" alt="article thumbnail"/>
        <div class="text">
            <div class="description"><?php echo $article->getDescription() ?></div>
            <div class="content"><?php echo $article->getContent() ?></div>
            <div class="last-edited">Last edited: <?php echo $article->getLastEdited() ?></div>
        </div>
    </div>
</div>