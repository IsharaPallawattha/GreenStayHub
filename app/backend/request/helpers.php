<?php
require_once "app/backend/request/Request.php";
require_once "app/backend/Status.php";
require_once "app/backend/advertisement/helpers.php";

function getRequest(int $id, mysqli $conn): ?Request
{
    $stmt = $conn->prepare("SELECT id, advert_id, student_id, comment, status, posted_on FROM requests WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $requestData = $result->fetch_assoc();
    if ($requestData && $result->num_rows == 1) {
        $status = Status::from(strtolower($requestData["status"]));
        return new Request(
            $id,
            getAdvertisement($requestData['advert_id'], $conn),
            $requestData['student_id'],
            $requestData['comment'],
            $status,
            $requestData['posted_on']
        );
    }
    return null;
}

/**
 * Get requests for a landlord.
 *
 * @param int $landlordId
 * @param mysqli $conn
 * @return Generator
 */
function getRequestsForLandlord(int $landlordId, mysqli $conn): Generator
{
    $sql = "SELECT r.id AS id
            FROM requests r
            INNER JOIN advertisements a ON r.advert_id = a.id
            WHERE a.landlord_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $landlordId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($requestData = $result->fetch_assoc()) {
        yield getRequest($requestData['id'], $conn);
    }
}

/**
 * Get requests from a student.
 *
 * @param int $studentId
 * @param mysqli $conn
 * @return Generator
 */
function getRequestsFromStudent(int $studentId, mysqli $conn): Generator
{
    $stmt = $conn->prepare("SELECT id, advert_id, student_id, comment, status, posted_on FROM requests WHERE student_id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($requestData = $result->fetch_assoc()) {
        $status = Status::from(strtolower($requestData["status"]));
        yield new Request(
            $requestData['id'],
            getAdvertisement($requestData['advert_id'], $conn),
            $studentId,
            $requestData['comment'],
            $status,
            $requestData['posted_on']
        );
    }
}

/**
 * @param int $advertId
 * @param int $studentId
 * @param string $comment
 * @param mysqli $conn
 * @return void
 * @throws Exception
 */
function createRequest(int $advertId, int $studentId, string $comment, mysqli $conn): void
{
    $sql = "INSERT INTO requests (advert_id, student_id, comment) VALUES (?, ?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $advertId, $studentId, $comment);
    $isSuccess = $stmt->execute();
    if (!$isSuccess) throw  new Exception("database error occurred");
}

