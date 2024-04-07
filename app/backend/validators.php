<?php
/**
 * @throws Exception
 */
function validateUsername($username): void
{
    if (is_null($username)) throw new Exception("username is required");
    // Check if the username does not exceed 30 characters
    if (strlen($username) > 30) throw new Exception("username exceed 30 characters");
}

/**
 * @throws Exception
 */
function validateName($name): void
{
    if (is_null($name)) throw new Exception("name is required");
    // Check if the name does not exceed 255 characters
    if (strlen($name) > 255) throw new Exception("name exceeds 255 characters");
}

/**
 * @throws Exception
 */
function validatePassword($password): void
{
    if (is_null($password)) throw new Exception("password is required");
    // Check if the password length is between 8 and 32 characters
    if (strlen($password) < 8 || strlen($password) > 32) {
        throw new Exception("password length is not between 8 and 32 characters");
    }
    // Check if the password contains at least one letter, one number, and one symbol
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        throw new Exception("password must contain at least one letter, one number, and one symbol");
    }
}
