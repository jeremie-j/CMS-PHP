<?php

namespace App\Manager;

use App\Entity\Post;

class PostManager extends BaseManager
{

    public function getAllPosts(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM post');
        $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($post) {
            return new Post(
                $post
            );
        }, $response);
    }

    public function getPostById(string $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM post WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return new Post(
                $user
            );
        } else {
            return null;
        }
    }

    public function getPostsByUserId(string $userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM post WHERE userId = :userId');
        $stmt->bindParam(':userId', $userId);

        $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($post) {
            return new Post(
                $post
            );
        }, $response);
    }

    public function createPost(Post $post)
    {
        $stmt = $this->pdo->prepare("INSERT INTO post (id,userId, title,content,createdAt)
        VALUES (:id, :userId,:title,:content,:createdAt)");

        $id = uniqid();
        $userId = $post->getUserId();
        $title = $post->getTitle();
        $content = $post->getContent();
        $time = new \DateTime();
        $time = $time->format('Y-m-d\TH:i:s');

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':createdAt', $time, \PDO::PARAM_STR);

        $stmt->execute();

        return new Post(array(
            'id' => $id,
            'userId' => $userId,
            'title' => $title,
            'content' => $content,
            'createdAt' => $time
        ));
    }

    public function updatePost(Post $post)
    {
        $stmt = $this->pdo->prepare("UPDATE post SET title = :title, content = :content
        WHERE id = :id");

        $id = $post->getId();
        $title = $post->getTitle();
        $content = $post->getContent();

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);

        $stmt->execute();

        return $this->getPostById($id);
    }

    public function deletePostById(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM post WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
