<?php
global $conn;
require_once "app/init.php";
require_once "app/backend/config.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/blob/Blob.php";
require_once "app/backend/advertisement/helpers.php";
require_once "app/backend/request/helpers.php";
require_once "app/backend/auth.php";
require_once "app/backend/helpers.php";
require_once "app/backend/extractors.php";
require_once "app/backend/validators.php";
require_once "app/backend/utilities.php";
require_once "app/backend/Status.php";
session_start();

$user = extractUser($_SESSION);

allowOnlyUserTypes($user, UserType::Warden);

$searchQuery = $_GET['searchQuery'] ?? null;
$searchStatus = $_GET['searchStatus'] ?? null;

try {
    if ($searchStatus !== null) {
        $status = Status::from($searchStatus);
    } else {
        $status = Status::Accepted;
    }
} catch (Exception $e) {
    insertError($_SESSION, $e->getMessage());
    redirectUsingUrlParam($user->getDashboardUrl());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Warden | GreenStayHub</title>
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
                <form class="search" action="<?php echo BASE_URL ?>warden.php" method="get">
                    <div class="input-container">
                        <label for="searchQuery">Search</label>
                        <input type="text" id="searchQuery" name="searchQuery" value="<?php echo $searchQuery ?? '' ?>">
                    </div>
                    <div class="input-container">
                        <label for="searchStatus">Status</label>
                        <select name="searchStatus" id="searchStatus">
                            <?php
                            foreach (Status::cases() as $s) {
                                echo '<option value="' . $s->value . '" ' . ($status->value === $s->value ? "Selected>" : ">") . $s->name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="map-container">
                <div id="map" class="map"></div>
            </div>
            <div class="empty-display">No advertisements to display</div>
            <?php
            foreach (searchAdvertisements($searchQuery, $status ?? Status::Accepted, $conn) as $advertisement) { ?>
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
    </div>
    
</div>
<script src="public/js/map.js"></script>
</body>
</html>
