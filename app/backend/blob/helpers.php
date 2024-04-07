<?php
require_once "app/backend/blob/Blob.php";

/**
 * @throws Exception
 */
function createBlob(mysqli $conn, string $contentPath): Blob
{
    $binaryContent = file_get_contents($contentPath);
    $type = mime_content_type($contentPath);
    $stmt = $conn->prepare("INSERT INTO blobs (content, type) VALUES (?, ?)");
    $stmt->bind_param("ss", $binaryContent, $type);
    $result = $stmt->execute();
    if (!$result) throw new Exception("Database error occurred");

    return new Blob($stmt->insert_id, $binaryContent, $type);
}

/**
 * @throws Exception
 */
function createWebpBlob(mysqli $conn, string $imagePath, int $quality): Blob
{
    $tempPath = tempnam(sys_get_temp_dir(), 'compressed');
    $info = getimagesize($imagePath);
    $isAlpha = false;
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($imagePath);
    elseif ($isAlpha = $info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($imagePath);
    } elseif ($isAlpha = $info['mime'] == 'image/png') {
        $image = imagecreatefrompng($imagePath);
    } else {
        throw new Exception("Unsupported image type.");
    }
    if ($isAlpha) {
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
    }
    imagewebp($image, $tempPath, $quality);
    return createBlob($conn, $tempPath);
}

function getBlob(mysqli $conn, int $id): ?Blob
{
    $stmt = $conn->prepare("SELECT id, content, type FROM blobs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blobData = $result->fetch_assoc();

    if ($blobData && $result->num_rows == 1) {
        return new Blob($blobData['id'], $blobData['content'], $blobData['type']);
    } else {
        return null;
    }
}