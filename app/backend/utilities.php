<?php
require_once "app/init.php";

function createHash(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function matchHash(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

function buildUrlWithParam(string $baseUrl, ?string $redirectUrl, string ...$pathSegments): string
{
    $params = array();
    if ($redirectUrl) $params["redirectUrl"] = $redirectUrl;
    return $baseUrl . implode("/", $pathSegments) . ($params ? '?' . http_build_query($params) : "");
}

function snakeToReadable($input): string
{
    $output = str_replace('_', ' ', $input);
    return ucwords($output);
}

function isSameWebsite($url): bool
{
    if (str_starts_with($url, BASE_URL) || str_starts_with($url, "/")) {
        return true;
    } else {
        return false;
    }
}

function getCurrentUrl(): string
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    $url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

function formatEpoch(string $timestamp): string
{
    try {
        $dt = new DateTime($timestamp);
        return $dt->format('Y-m-d H:i:s');
    } catch (Exception) {
        return $timestamp;
    }
}
