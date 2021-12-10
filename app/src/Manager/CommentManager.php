<?php

namespace App\Manager;

use App\Entity\Comment;

class CommentManager extends BaseManager
{
    public function getCommentById(string $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comment WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $comment = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return new Comment(
                $comment
            );
        } else {
            return null;
        }
    }

    public function getCommentsByUserId(string $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comment WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($comment) {
            return new Comment(
                $comment
            );
        }, $response);
    }

    public function getCommentByPostId(string $postId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM comment WHERE postId = :postId');
        $stmt->bindParam(':postId', $postId);
        $stmt->execute();

        $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($comment) {
            return new Comment(
                $comment
            );
        }, $response);
    }

    public function createComment(comment $comment)
    {
        $stmt = $this->pdo->prepare("INSERT INTO comment (id,userId,postId,content,createdAt)
        VALUES (:id, :userId,:title,:content,:createdAt)");

        $id = uniqid();
        $userId = $comment->getUserId();
        $postId = $comment->getPostId();
        $content = $comment->getContent();
        $time = new \DateTime();
        $time = $time->format('Y-m-d\TH:i:s');

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $postId, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':createdAt', $time, \PDO::PARAM_STR);

        $stmt->execute();

        return new Comment(array(
            'id' => $id,
            'userId' => $userId,
            'title' => $postId,
            'content' => $content,
            'createdAt' => $time
        ));
    }

    public function deleteCommentById(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM comment WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
