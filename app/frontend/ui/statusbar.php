<?php
require_once "app/init.php";
require_once "app/backend/utilities.php";
?>
<div class="statusbar">
    <div id="breadcrumbs">
        <?php
        $breadcrumbs = array();
        $pathSegments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'] ?? null, PHP_URL_PATH), '/'));

        // Construct the breadcrumbs based on the URL path segments
        $url = BASE_URL;
        $breadcrumbs[] = '<a href="' . $url . '">Home</a>';
        $url = rtrim($url, "/");
        foreach ($pathSegments as $segment) {
            if ($segment == "index.php" || $segment == "") break;
            $url .= '/' . $segment;
            $breadcrumbs[] = '<i class="fa-solid fa-arrow-right"></i><a href="' . $url . '">' . snakeToReadable(preg_replace('/\.php$/', '', $segment)) . '</a>';
        }

        echo implode('', $breadcrumbs);
        ?>
    </div>
    <div id="clock"></div>
</div>
<script src="<?php echo PUBLIC_JS ?>statusbar.js"></script>