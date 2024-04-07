<?php
require_once "app/backend/advertisement/Advertisement.php";
require_once "app/backend/Status.php";

class Request
{
    public function __construct(private readonly int $id, private readonly Advertisement $advertisement, private readonly int $studentId, private readonly string $comment, private Status $status, private readonly string $postedOn)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
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
        $StatusStr = $status->value;
        $sql = "UPDATE requests SET status=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $StatusStr, $id);
        if ($stmt->execute()) {
            $this->status = $status;
        } else {
            throw new Exception("Database error occurred");
        }
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getAdvertisement(): Advertisement
    {
        return $this->advertisement;
    }

    public function getPostedOn(): string
    {
        return $this->postedOn;
    }
}
