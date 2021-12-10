<?php

namespace App\Controller;

use App\Manager\UserManager;
use App\Fram\Factories\PDOFactory;
use App\Fram\Utils\Flash;
use App\Entity\User;

class authentificationController extends BaseController
{
    public function executeAuthentification()
    {
        $this->render(
            'authentification.php',
            [],
            'authentification'
        );
    }

    public function executePostSignUp()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $verifPassword = $_POST['verifPassword'];
        $admin = $_POST['admin'];

        if (!empty($username) && !empty($password) && !empty($verifPassword)) {
            if ($password !== $verifPassword) {
                Flash::setFlash('alert', "Passwords don't match.");
                header('Location: /authentification');
            } else {
                $userManager = new UserManager(PDOFactory::getMysqlConnection());
                if ($userManager->getUserByUsername($username)) {
                    Flash::setFlash('alert', "An user already exist with this username.");
                    header('Location: /authentification');
                } else {
                    $createdUser = $userManager->createUser(new User(array(
                        'username' => $username,
                        'password' => $password,
                        'admin' => $admin
                    )));

                    $_SESSION['loggedUser'] = $createdUser;
                    header('Location: /');
                }
            }
        } else {
            header('Location: /authentification');
        }
    }

    public function executePostSignIn()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
            $userManager = new UserManager(PDOFactory::getMysqlConnection());
            $user = $userManager->getUserByUsername($username);
            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    $_SESSION['loggedUser'] = $user;
                    header('Location: /');
                } else {
                    Flash::setFlash('alert', "Invalid Password");
                    header('Location: /authentification');
                }
            } else {
                Flash::setFlash('alert', "User not found");
                header('Location: /authentification');
            }
        } else {
            header('Location: /authentification');
        }
    }

    public function executePostLogout()
    {
        session_destroy();
        header('Location: /authentification');
    }
}
