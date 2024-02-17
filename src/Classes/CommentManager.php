<?php

namespace App\Cssconverter\Classes;

use DateTimeImmutable;
use Exception;

class CommentManager
{
    private DataBase $database;

    public function __construct(DataBase $database)
    {
        $this->database = $database;
    }

    public function addComment(Comment $comment): void
    {
        $pdo = $this->database->connect();
        $sql = "INSERT INTO comments (authorName, email, content, created_at) VALUES (?, ?, ?, ?)";
        // Assurez-vous que la commande des paramètres correspond à celle dans la requête SQL
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $comment->getAuthorName(),
            $comment->getEmail(), // Assurez-vous que la classe Comment a une méthode getEmail
            $comment->getContent(),
            $comment->getCreatedAt()->format('Y-m-d H:i:s') // Format standard SQL pour les dates
        ]);
    }

    /**
     * @throws Exception
     */
    public function getComments(): array
    {
        $comments = [];
        $pdo = $this->database->connect();
        $sql = "SELECT authorName, content, created_at FROM comments ORDER BY created_at DESC";
        $statement = $pdo->query($sql);

        while ($row = $statement->fetch()) {
            $comment = new Comment($row['authorName'], $row['content']);
            $comment->setCreatedAt(new DateTimeImmutable($row['created_at']));
            $comments[] = $comment;
        }

        return $comments;
    }
}