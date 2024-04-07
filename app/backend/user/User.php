<?php
require_once "app/init.php";
require_once "app/backend/user/UserType.php";
require_once "app/backend/validators.php";
require_once "app/backend/utilities.php";

class User
{
    public function __construct(private readonly int $id, private readonly ?int $reference, private readonly string $username, private string $name, private UserType $type, private Blob $avatar)
    {
    }

    /**
     * Get the dashboard url specific to this user's type.
     *
     * @return string
     */
    public function getDashboardUrl(): string
    {
        return BASE_URL . $this->type->value . ".php";
    }

    /**
     * @throws Exception
     */
    public function update(?string $password, ?string $name, ?string $avatarPath, mysqli $conn): void
    {
        $id = $this->id;
        $isSuccess = true;
        if ($password) {
            validatePassword($password);
            $pwdHash = createHash($password);
            $sql = "UPDATE users SET pwdHash=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $pwdHash, $id);
            $isSuccess = $stmt->execute();
        }
        if ($name) {
            validateName($name);
            $sql = "UPDATE users SET name=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $name, $id);
            if ($stmt->execute()) {
                $this->name = $name;
            } else {
                $isSuccess = false;
            }
        }
        if ($avatarPath) {
            $avatar = createWebpBlob($conn, $avatarPath, 100);
            $sql = "UPDATE users SET avatar_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $avatarId = $avatar->getId();
            $stmt->bind_param('ii', $avatarId, $id);
            if ($stmt->execute()) {
                $this->avatar = $avatar;
            } else {
                $isSuccess = false;
            }
        }
        if (!$isSuccess) throw  new Exception("database error occurred");
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReference(): ?int
    {
        return $this->reference;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): UserType
    {
        return $this->type;
    }

    public function getAvatar(): Blob
    {
        return $this->avatar;
    }
}
