<?php
require_once "app/init.php";
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/helpers.php";
require_once "app/backend/utilities.php";

/**
 * Allows only specified user types to pass and redirects other users to their dashboards or non-users to the login page.
 *
 * @param User|null $user
 * @param UserType ...$userTypes
 * @return void
 */
function allowOnlyUserTypes(?User $user, UserType ...$userTypes): void
{
    allowOnlyUsers($user);
    if (in_array($user->getType(), $userTypes)) return;
    header("Location: " . $user->getDashboardUrl());
    exit();
}

/**
 * Allows only users to pass and redirects others to login page with current url as the redirectUrl.
 *
 * @param User|null $user
 * @return void
 */
function allowOnlyUsers(?User $user): void
{
    if ($user != null) return;
    header("Location: " . buildUrlWithParam(BASE_URL, getCurrentUrl(), "login.php"));
    exit();
}

/**
 * Allows only non-users to pass and redirects others to the redirectUrl or the dashboard.
 *
 * @param User|null $user
 * @return void
 */
function allowOnlyNonUsers(?User $user): void
{
    if ($user == null) return;
    redirectUsingUrlParam($user->getDashboardUrl());
}