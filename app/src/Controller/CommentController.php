<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Fram\Factories\PDOFactory;
use App\Fram\Utils\Flash;
use App\Manager\CommentManager;

class CommentController extends BaseController
{

    public function executePostCreateComment()
    {
        $user =  $_SESSION['loggedUser'];
        $postId = $_GET['postId'];
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $comment = new Comment(array(
            'userId' => $user->getId(),
            'postId' => $postId,
            'content' => $content
        ));
        $commentManager = new CommentManager(PDOFactory::getMysqlConnection());
        $commentManager->createComment($comment);
        header('Location: /post?id=' . $postId);
    }

    public function executePostRemoveComment()
    {
        $user =  $_SESSION['loggedUser'];
        $postId = $_GET['postId'];
        $commentId =  $_GET['id'];

        $commentManager = new CommentManager(PDOFactory::getMysqlConnection());
        $comment = $commentManager->getCommentById($commentId);

        if ($comment->getUserId() != $user->getId() && !$user->getAdmin()) {
            Flash::setFlash('alert', "You can't delete comment of other people.");
            header('Location: /post?id=' . $postId);
            exit;
        }

        $commentManager->deleteCommentById($commentId);
        header('Location: /post?id=' . $postId);
    }
}
