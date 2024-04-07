<?php
require_once "app/init.php";
require_once "app/backend/utilities.php";

use JetBrains\PhpStorm\NoReturn;

/**
 * Redirect to the redirectUrl, defaultUrl, or BASE_URL.
 *
 * @param string|null $defaultUrl
 * @return void
 */
#[NoReturn] function redirectUsingUrlParam(?string $defaultUrl): void
{
    $url = extractRedirectUrl($_GET);
    if (!isSameWebsite($url)) $url = $defaultUrl ?? BASE_URL;
    header("Location: " . $url);
    exit();
}
