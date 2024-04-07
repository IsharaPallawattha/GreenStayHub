<?php
require_once "app/backend/blob/helpers.php";

class Article
{
    public function __construct(private readonly int $id, private string $title, private string $description, private Blob $thumbnail, private string $content, private readonly string $lastEdited)
    {
    }

    /**
     * @throws Exception
     */
    public function update(?string $title, ?string $description, ?string $thumbnailPath, ?string $content, mysqli $conn): void
    {
        $id = $this->id;
        $isSuccess = true;
        if ($title) {
            $sql = "UPDATE articles SET title=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $title, $id);
            if (!$stmt->execute()) $isSuccess = false;

        }
        if ($description) {
            $sql = "UPDATE articles SET description=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $description, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        $thumbnail = null;
        if ($thumbnailPath) {
            $thumbnail = createWebpBlob($conn, $thumbnailPath, 100);
            $sql = "UPDATE articles SET thumbnail_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $thumbnailId = $thumbnail->getId();
            $stmt->bind_param('ii', $thumbnailId, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        if ($content) {
            $sql = "UPDATE articles SET content=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $content, $id);
            if (!$stmt->execute()) $isSuccess = false;
        }
        $sql = "UPDATE articles SET last_edited=CURRENT_TIMESTAMP WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) $isSuccess = false;

        if ($isSuccess && $conn->commit()) {
            $this->title = $title ?? $this->title;
            $this->description = $description ?? $this->description;
            $this->thumbnail = $thumbnail ?? $this->thumbnail;
            $this->content = $content ?? $this->content;
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function getLastEdited(): string
    {
        return $this->lastEdited;
    }
}
