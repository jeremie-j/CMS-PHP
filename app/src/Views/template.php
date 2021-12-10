<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title><?= $title; ?></title>
    <style>
        p {
            margin-bottom: 0;
        }

        .postcontent {
            margin: 1em;
        }

        .post {
            background-color: aliceblue;
            display: flex;
            flex-direction: column;
            border: solid black 2px;
            margin-bottom: 2em;
            word-break: break-all;
        }

        .textarea {
            width: 100%;
        }

        .rect {
            height: 1px;
            background-color: black;
        }

        .card {
            background-color: lightgrey;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            word-break: break-all;
            height: fit-content;
            margin-bottom: 2em;
        }

        .card2 {
            background-color: lightgrey;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                    <li><a href="authentification" class="nav-link px-2 text-white">Connect</a></li>
                    <?php if (isset($_SESSION["loggedUser"])) : ?>
                        <li><a href="postlogout" class="nav-link px-2 text-white">Logout</a></li>
                    <?php endif; ?>
                    <li>
                        <p class="nav-link px-2 text-secondary "> <?php
                                                                    $username = isset($_SESSION["loggedUser"]) ? 'Logged as ' . $_SESSION["loggedUser"]->getUsername() : 'Not logged';
                                                                    echo $username; ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <?php if (\App\Fram\Utils\Flash::hasFlash('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= \App\Fram\Utils\Flash::getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (\App\Fram\Utils\Flash::hasFlash('alert')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= \App\Fram\Utils\Flash::getFlash('alert'); ?>
        </div>
    <?php endif; ?>
    <div style="width:100%;display:flex">
        <div style="max-width: 600px;margin:0 auto">
            <?= $content; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
<style>
</style>