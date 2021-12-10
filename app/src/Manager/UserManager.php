<?php

namespace App\Manager;

use App\Entity\User;

class UserManager extends BaseManager
{
    public function getAllUsers(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM user');
        $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($user) {
            return new User(
                $user
            );
        }, $response);
    }

    public function getUserById(string $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return new User(
                $user
            );
        } else {
            return null;
        }
    }

    public function getUserByUsername(string $username)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return new User(
                $user
            );
        } else {
            return null;
        }
    }


    public function createUser(User $user)
    {
        if ($this->getUserByUsername($user->getUsername())) {
            return;
        }

        $stmt = $this->pdo->prepare("INSERT INTO user (id,username, password,admin,createdAt)
        VALUES (:id, :username,:password,:admin,:createdAt)");

        $id = uniqid();
        $username = $user->getUsername();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $admin = $user->getAdmin();
        $time = new \DateTime();
        $time = $time->format('Y-m-d\TH:i:s');

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':admin', $admin, \PDO::PARAM_BOOL);
        $stmt->bindParam(':createdAt', $time, \PDO::PARAM_STR);

        $stmt->execute();

        return new User(array(
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'admin' => $admin,
            'createdAt' => $time
        ));
    }

    public function updateUser(User $user)
    {
        $stmt = $this->pdo->prepare("UPDATE user SET username = :username, password = :password,admin = :admin
        WHERE id = :id");

        $id = $user->getId();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $admin = $user->getAdmin();

        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), \PDO::PARAM_STR);
        $stmt->bindParam(':admin', $admin, \PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->getUserById($id);
    }

    public function deleteUserById(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
