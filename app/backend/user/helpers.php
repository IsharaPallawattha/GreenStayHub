<?php
require_once "app/backend/user/User.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/validators.php";
require_once "app/backend/blob/helpers.php";

/**
 * Get the user data from database and create a matching User object.
 *
 * @param string $username
 * @param string $password
 * @param mysqli $conn
 * @return User
 * @throws Exception if the username or password is incorrect, and on database failures.
 */
function getUser(string $username, string $password, mysqli $conn): User
{
    validateUsername($username);
    validatePassword($password);

    $sql = "SELECT id, reference, username, name, pwdHash, type, avatar_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result and $result->num_rows == 1) {
        $record = $result->fetch_assoc();
        $type = UserType::from(strtolower($record["type"]));
        if (matchHash($password, $record["pwdHash"])) {
            return new User(
                $record["id"],
                $record["reference"],
                $record["username"],
                $record["name"],
                $type,
                getBlob($conn, $record["avatar_id"])
            );
        }
    }
    throw new Exception("username or password is incorrect");
}

/**
 * Create a user in the database from the provided data and return the matching User object
 *
 * @param int|null $reference
 * @param string $username
 * @param string $password
 * @param string $name
 * @param UserType $type
 * @param string $avatarPath
 * @param mysqli $conn
 * @return User
 * @throws Exception if the provided data are invalid, the username is already taken, or a database error had occurred.
 */
function createUser(?int $reference, string $username, string $password, string $name, UserType $type, string $avatarPath, mysqli $conn): User
{
    validateUsername($username);
    validatePassword($password);
    validateName($name);
    $avatar = createWebpBlob($conn, $avatarPath, 100);

    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result and $result->num_rows > 0) {
        throw new Exception("username already taken");
    }

    $pwdHash = createHash($password);
    $typeStr = $type->name;
    $avatarId = $avatar->getId();
    $sql = "INSERT INTO users (reference, username, name, pwdHash, type, avatar_id) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $reference, $username, $name, $pwdHash, $typeStr, $avatarId);
    $isSuccess = $stmt->execute();

    if ($isSuccess) {
        $id = mysqli_insert_id($conn);
        return new User($id, $reference, $username, $name, $type, $avatar);
    }
    throw  new Exception("database error occurred");
}

