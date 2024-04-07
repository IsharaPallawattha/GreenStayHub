<?php
require_once "app/backend/user/User.php";

function extractUser(array $session): ?User
{
    return $session["user"] ?? null;
}

function extractRedirectUrl(array $getRequest): ?string
{
    return $getRequest["redirectUrl"] ?? null;
}
