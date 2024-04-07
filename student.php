<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/article/helpers.php";
require_once "app/backend/request/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/extractors.php";
require_once "app/backend/validators.php";
require_once "app/backend/utilities.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Student);

$search = $_GET['search'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student | GreenStayHub</title>
    <?php include "app/frontend/includes/head.php" ?>
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>topbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>statusbar.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS ?>app.css">
</head>
<body>
<div class="app-wrapper">
    <?php include "app/frontend/ui/topbar.php"; ?>
    <?php include "app/frontend/ui/alerts.php" ?>
    <div class="app">
        <div class="container">
            <div class="title-bar">
                <div class="title">Advertisements</div>
                <form class="search" action="<?php echo BASE_URL ?>student.php" method="get">
                    <div class="input-container">
                        <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input type="text" id="search" name="search" value="<?php echo $search ?? '' ?>">
                    </div>
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="map-container">
                <div id="map" class="map"></div>
            </div>
            <div class="empty-display">No advertisements to display</div>
            <?php
            foreach (searchAdvertisements($search, Status::Accepted, $conn) as $advertisement) { ?>
                <div class="map-item"
                     data-lat="<?php echo $advertisement->getLatitude() ?>"
                     data-lng="<?php echo $advertisement->getLongitude() ?>"
                     data-title="<?php echo $advertisement->getTitle() ?>"
                     data-desc="<?php echo $advertisement->getDescription() ?>"
                     data-thumb-uri="<?php echo $advertisement->getThumbnail()->getDataUri() ?>"
                     data-url="<?php echo BASE_URL . 'advertisement.php?action=view&id=' . $advertisement->getId() ?>"
                >
                    <?php include "app/frontend/ui/advertisement.php"; ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="container">
            <div class="title-bar">
                <div class="title">Articles</div>
            </div>
            <div class="empty-display">No articles to display</div>
            <?php
            foreach (getAllArticles($conn) as $article) {
                include "app/frontend/ui/article.php";
            }
            ?>
        </div>
        <div class="container">
            <div class="title-bar">
                <div class="title">Requests</div>
            </div>
            <div class="empty-display">No requests to display</div>
            <?php
            foreach (getRequestsFromStudent($user->getId(), $conn) as $request) {
                include "app/frontend/ui/request.php";
            }
            ?>
        </div>
    </div>
    
</div>
<script src="public/js/map.js"></script>
</body>
</html>
