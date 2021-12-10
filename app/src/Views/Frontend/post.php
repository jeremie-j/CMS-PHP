<h1></h1>

<?php
if (\App\Fram\Utils\Flash::hasFlash('alert')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= \App\Fram\Utils\Flash::getFlash('alert'); ?>
    </div>
<?php endif; ?>
<?php
/**
 * @var $users \App\Entity\User[] 
 * @var $post \App\Entity\Post
 * @var $comments \App\Entity\Comments[]
 * @var $editionDisabled boolean
 */

use \App\Manager\CommentManager;
use App\Fram\Factories\PDOFactory;
?>
<div class="card">
    <div class="postcontent">
        <form action="PostEditPost?id=<? echo $post->getId() ?>" method="post">
            <div>
                <label for="title">Title : </label>
                <input id="title" name="title" type="text" minlength="3" value="<? echo $post->getTitle() ?>" <? echo $canEdit ? '' : 'disabled'; ?>>
            </div>
            <div>
                <textarea id=" content" name="content" type="text" minlength="3" rows="4" cols="50" <? echo $canEdit ? '' : 'disabled'; ?>><? echo $post->getContent() ?></textarea>
            </div>
            <button style="background-color:yellow" <? echo $canEdit ? '' : 'disabled'; ?>>Update post</button>
        </form>
        <form action="PostRemovePost?id=<? echo $post->getId() ?>" method="post">
            <button type="submit" style="background-color:red" <? echo $canEdit ? '' : 'disabled'; ?>>Delete post</button>
        </form>
    </div>
</div>
<div class="card">
    <div class="postcontent">
        <form action="PostCreateComment?postId=<? echo $post->getId() ?>" method="post">
            <div>
                <textarea id="content" name="content" type="text" minlength="3" rows="4" cols="50" placeholder="Write a comment..."></textarea>
            </div>
            <button>Create Comment</button>
        </form>
    </div>
</div>
<?php
foreach ($comments as $comment) {
    $author = current(
        array_filter(
            $users,
            function ($user) use ($comment) {
                if ($user->getId() ==  $comment->getUserId()) {
                    return $user;
                }
            }
        )
    )
?>
    <div class="card">
        <div class="postcontent">
            <form action="PostRemoveComment?id=<? echo $comment->getId() ?>&postId=<? echo $post->getId() ?>" method="post">
                <div>
                    <textarea id="content" name="content" type="text" minlength="3" rows="4" cols="50" disabled><? echo $comment->getContent() ?></textarea>
                    <div>By <? echo $author->getUsername() ?> at <? echo $comment->getCreatedAt()->format('Y-m-d\TH:i:s') ?></div>
                </div>
                <button>Delete Comment</button>
            </form>
        </div>
    </div>

<?php
}

?>