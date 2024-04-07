<?php
require_once "app/backend/advertisement/Advertisement.php";
require_once "app/backend/blob/helpers.php";
require_once "app/backend/Status.php";

function getAdvertisement(int $id, mysqli $conn): ?Advertisement
{
    $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, picture_ids, landlord_id, last_edited, status, longitude, latitude FROM advertisements WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $advertData = $result->fetch_assoc();

    if ($advertData and $result->num_rows == 1) {
        $pictures = array();
        foreach (unserialize($advertData['picture_ids']) ?? array() as $picture_id) {
            $pictures[] = getBlob($conn, $picture_id);
        }
        $status = Status::from(strtolower($advertData["status"]));
        return new Advertisement(
            $advertData['id'],
            $advertData['title'],
            $advertData['description'],
            getBlob($conn, $advertData['thumbnail_id']),
            $pictures,
            $advertData['landlord_id'],
            $advertData['last_edited'],
            $status,
            $advertData['longitude'],
            $advertData['latitude']
        );
    }
    return null;
}

function getLandlordAdvertisements(int $landlordId, mysqli $conn): Generator
{
    $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, picture_ids, landlord_id, last_edited, status, longitude, latitude FROM advertisements WHERE landlord_id = ?");
    $stmt->bind_param("i", $landlordId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($advertData = $result->fetch_assoc()) {
        $pictures = array();
        foreach (unserialize($advertData['picture_ids']) ?? array() as $picture_id) {
            $pictures[] = getBlob($conn, $picture_id);
        }
        $status = Status::from(strtolower($advertData["status"]));
        yield new Advertisement(
            $advertData['id'],
            $advertData['title'],
            $advertData['description'],
            getBlob($conn, $advertData['thumbnail_id']),
            $pictures,
            $advertData['landlord_id'],
            $advertData['last_edited'],
            $status,
            $advertData['longitude'],
            $advertData['latitude']
        );
    }
}

function searchAdvertisements(?string $query, Status $status, mysqli $conn): Generator
{
    $statusStr = $status->value;
    if ($query) {
        $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, picture_ids, landlord_id, last_edited, longitude, latitude FROM advertisements WHERE status = ? AND MATCH (title, description) AGAINST (? WITH QUERY EXPANSION)");
        $stmt->bind_param("ss", $statusStr, $query);
    } else {
        $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, picture_ids, landlord_id, last_edited, longitude, latitude FROM advertisements WHERE status = ?");
        $stmt->bind_param("s", $statusStr);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($advertData = $result->fetch_assoc()) {
        $pictures = array();
        foreach (unserialize($advertData['picture_ids']) ?? array() as $picture_id) {
            $pictures[] = getBlob($conn, $picture_id);
        }
        yield new Advertisement(
            $advertData['id'],
            $advertData['title'],
            $advertData['description'],
            getBlob($conn, $advertData['thumbnail_id']),
            $pictures,
            $advertData['landlord_id'],
            $advertData['last_edited'],
            $status,
            $advertData['longitude'],
            $advertData['latitude']
        );
    }
}

/**
 * @throws Exception
 */
function createAdvertisement(string $title, string $description, string $thumbnailPath, array $picturePaths, int $landlordId, float $longitude, float $latitude, mysqli $conn): void
{
    $thumbnail = createWebpBlob($conn, $thumbnailPath, 100);
    $thumbnailId = $thumbnail->getId();
    $pictureIds = serialize(array_map(fn($picPath): int => createBlob($conn, $picPath)->getId(), $picturePaths));
    $stmt = $conn->prepare("INSERT INTO advertisements (title, description, thumbnail_id, picture_ids, landlord_id, longitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisidd", $title, $description, $thumbnailId, $pictureIds, $landlordId, $longitude, $latitude);
    if (!$stmt->execute()) throw new Exception("Database error occurred");
}
