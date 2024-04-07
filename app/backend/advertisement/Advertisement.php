<?php
require_once "app/backend/blob/Blob.php";
require_once "app/backend/blob/helpers.php";
require_once "app/backend/Status.php";

class Advertisement
{
    public function __construct(private readonly int $id, private string $title, private string $description, private Blob $thumbnail, private array $pictures, private readonly int $landlordId, private string $lastEdited, private Status $status, private readonly float $longitude, private readonly float $latitude)
    {
    }

    /**
     * @throws Exception
     */
    public function update(?string $title, ?string $description, ?string $thumbnailPath, ?array $picturePaths, mysqli $conn): void
    {
        $id = $this->id;
        $isSuccess = true;
        if ($title) {
            $sql = "UPDATE advertisements SET title=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $title, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        if ($description) {
            $sql = "UPDATE advertisements SET description=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $description, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        $thumbnail = null;
        if ($thumbnailPath) {
            $thumbnail = createWebpBlob($conn, $thumbnailPath, 100);
            $sql = "UPDATE advertisements SET thumbnail_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $thumbnailId = $thumbnail->getId();
            $stmt->bind_param('ii', $thumbnailId, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        $pictures = null;
        if ($picturePaths) {
            $pictures = array_map(fn($picPath): Blob => createBlob($conn, $picPath), $picturePaths);
            $pictureIds = serialize(array_map(fn(Blob $pic): int => $pic->getId(), $pictures));
            $sql = "UPDATE advertisements SET picture_ids=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $pictureIds, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        $sql = "UPDATE advertisements SET last_edited=CURRENT_TIMESTAMP WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) $isSuccess = false;

        if ($isSuccess && $conn->commit()) {
            $this->title = $title ?? $this->title;
            $this->description = $description ?? $this->description;
            $this->thumbnail = $thumbnail ?? $this->thumbnail;
            $this->pictures = $pictures ?? $this->pictures;
            $this->lastEdited = $lastEdited ?? $this->lastEdited;
        } else {
            $conn->rollback();
            throw  new Exception("database error occurred");
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThumbnail(): Blob
    {
        return $this->thumbnail;
    }

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function getLastEdited(): string
    {
        return $this->lastEdited;
    }

    public function getLandlordId(): int
    {
        return $this->landlordId;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @throws Exception
     */
    public function setStatus($conn, Status $status): void
    {
        $id = $this->id;
        $StatusStr = $status->name;
        $sql = "UPDATE advertisements SET status=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $StatusStr, $id);
        if ($stmt->execute()) {
            $this->status = $status;
        } else {
            throw new Exception("Database error occurred");
        }
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }
}