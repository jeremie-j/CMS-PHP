<?php

namespace App\Controller;

use App\Entity\Post;
use App\Fram\Factories\PDOFactory;
use App\Fram\Utils\Flash;
use App\Manager\UserManager;
use App\Manager\PostManager;
use App\Manager\CommentManager;

class PostController extends BaseController
{
    /**
     * Show all Posts
     */
    public function executeIndex()
    {
        $userManager = new UserManager(PDOFactory::getMysqlConnection());
        $users = $userManager->getAllUsers();

        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $posts = $postManager->getAllPosts();

        $this->render(
            'home.php',
            [
                'users' => $users,
                'posts' => $posts,
            ],
            'Home page'
        );
    }

    public function executeViewPost()
    {
        $user = $_SESSION['loggedUser'];
        $postId =  $_GET['id'];
        $userManager = new UserManager(PDOFactory::getMysqlConnection());
        $users = $userManager->getAllUsers();

        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $post = $postManager->getPostById($postId);

        $commentManager = new CommentManager(PDOFactory::getMysqlConnection());
        $comments = $commentManager->getCommentByPostId($postId);

        $this->render(
            'post.php',
            [
                'users' => $users,
                'post' => $post,
                'comments' => $comments,
                'canEdit' => ($post->getUserId() == $user->getId())
            ],
            $post->getTitle()
        );
    }

    public function executePostCreatePost()
    {
        $user =  $_SESSION['loggedUser'];
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $post = new Post(array(
            'userId' => $user->getId(),
            'title' => $title,
            'content' => $content
        ));
        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $postManager->createPost($post);
        header('Location: /');
    }

    public function executePostEditPost()
    {
        $user =  $_SESSION['loggedUser'];
        $postId =  $_GET['id'];

        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $post = $postManager->getPostById($postId);

        if ($post->getUserId() != $user->getId() && !$user->getAdmin()) {
            Flash::setFlash('alert', "You can't edit post of other people.");
            header('Location: /post?id=' . $post->getId());
            exit;
        }

        $post->setTitle(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
        $post->setContent(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS));

        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $postManager->updatePost($post);
        header('Location: /post?id=' . $postId);
    }

    public function executePostRemovePost()
    {
        $user =  $_SESSION['loggedUser'];
        $postId =  $_GET['id'];

        $postManager = new PostManager(PDOFactory::getMysqlConnection());
        $post = $postManager->getPostById($postId);

        if ($post->getUserId() != $user->getId() && !$user->getAdmin()) {
            Flash::setFlash('alert', "You can't delete post of other people.");
            header('Location: /post?id=' . $postId);
            exit;
        }

        $postManager->deletePostById($postId);
        header('Location: /');
    }
}
