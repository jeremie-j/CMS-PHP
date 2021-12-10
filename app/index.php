<?php
require './vendor/autoload.php';
session_start();

$router = new \App\Fram\Router();
$router->getController();
