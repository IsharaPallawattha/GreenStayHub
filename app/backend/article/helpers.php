<?php
require_once "app/backend/blob/Blob.php";
require_once "app/backend/article/Article.php";
require_once "app/backend/blob/helpers.php";

/**
 * Fetches the article from the database and returns the Article object.
 *
 * @param int $id
 * @param mysqli $conn
 * @return Article|null
 */
function getArticle(int $id, mysqli $conn): ?Article
{
    $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, content, last_edited FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $articleData = $result->fetch_assoc();

    if ($articleData and $result->num_rows == 1) {
        return new Article(
            $articleData['id'],
            $articleData['title'],
            $articleData['description'],
            getBlob($conn, $articleData['thumbnail_id']),
            $articleData['content'],
            $articleData['last_edited']
        );
    }

    return null;
}

/**
 * Generator for looping through every article in the database as Article objects.
 *
 * @param mysqli $conn
 * @return Generator
 */
function getAllArticles(mysqli $conn): Generator
{
    $stmt = $conn->prepare("SELECT id, title, description, thumbnail_id, content, last_edited FROM articles");
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) return;

    while ($articleData = $result->fetch_assoc()) {
        yield new Article(
            $articleData['id'],
            $articleData['title'],
            $articleData['description'],
            getBlob($conn, $articleData['thumbnail_id']),
            $articleData['content'],
            $articleData['last_edited']
        );
    }
}

/**
 * Inserts a new article into the database.
 *
 * @param string $title
 * @param string $description
 * @param string $thumbnailPath
 * @param string $content
 * @param mysqli $conn
 * @return void
 * @throws Exception
 */
function createArticle(string $title, string $description, string $thumbnailPath, string $content, mysqli $conn): void
{
    $thumbnail = createWebpBlob($conn, $thumbnailPath, 100);
    $thumbnailId = $thumbnail->getId();
    $stmt = $conn->prepare("INSERT INTO articles (title, description, thumbnail_id, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $description, $thumbnailId, $content);
    if (!$stmt->execute()) throw new Exception("Database error occurred");
}