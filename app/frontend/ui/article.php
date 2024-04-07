<?php
require_once "app/init.php";
require_once "app/backend/article/Article.php";

/* @var Article $article */
global $article;
$thumbnailSrc = $article->getThumbnail()->getDataUri();
$lastEdited = formatEpoch($article->getLastEdited());
?>

<div class="content">
    <img class="thumbnail" alt="thumbnail" src="<?php echo $thumbnailSrc ?>"/>
    <div class="text">
        <a class="title" href="<?php echo BASE_URL . 'article.php?action=view&id=' . $article->getId() ?>">
            <?php echo $article->getTitle() ?>
        </a>
        <div class="description">
            <?php echo $article->getDescription() ?>
        </div>
        <div class="last-edited">
            <?php echo $lastEdited ?>
        </div>
    </div>
</div>