<h1>Register</h1>
<?php if (\App\Fram\Utils\Flash::hasFlash('alert')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= \App\Fram\Utils\Flash::getFlash('alert'); ?>
    </div>
<?php endif; ?>
</form>
<form action="postsignin" method="post">
    <div>
        <label for="username">Username :</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password">
    </div>
    <button>Sign in</button>
</form>
<p>Or</p>
<form action="postsignup" method="post">
    <div>
        <label for="username">Username :</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Password :</label>
        <input type="password" id="password" name="password">
    </div>
    <div>
        <label for="verifPassword">Verify password :</label>
        <input type="password" id="verifPassword" name="verifPassword">
    </div>
    <div>
        <label for="admin">Admin :</label>
        <input type="hidden" class="admin" name="admin" value="0" />
        <input type="checkbox" class="admin" name="admin" value="1">
    </div>
    <button>Register</button>