<h1>Post list</h1>

<?php
/**
 * @var $users \App\Entity\User[] 
 * @var $posts \App\Entity\Post[]
 */
?>
<form action="PostCreatePost" method="post" class="card">
    <div class="postcontent">
    <div>
        <label for="title">Title</label>
        <input id="title" name="title">
    </div>
    <div>
        <textarea id="content" name="content" rows="4" cols="50" placeholder="Type you new post here..."></textarea>
        <button style="display: block;" type="submit">Post !</button>
    </div>
</form>
<?php
foreach ($posts as $post) {
    $author = current(
        array_filter(
            $users,
            function ($user) use ($post) {
                if ($user->getId() ==  $post->getUserId()) {
                    return $user;
                }
            }
        )
    )
?>
    <a href="/post?id=<? echo $post->getId() ?>" style="text-decoration: none;color: inherit;">
        <div style="cursor:pointer;margin-top:1em;">
            <h3><? echo $post->getTitle() ?></h3>
            <p><? echo $post->getContent() ?></p>
            <p style="display:flex;justify-content:space-between; color:grey"><span>By <? echo $author->getUsername() ?></span><span>On <? echo $post->getCreatedAt()->format('Y-m-d\ H:i:s') ?></span></p>
        </div>
    </a>

<?php
}

?>