<?php
$route = $_GET['route'] ?? 'home';
$route = explode('/', $route);
//var_dump($route);
?>

<?php

$__SERVER_ROOT = '/home/jbencehu';
$__CLIENT_ROOT = '';

if ($route[0] == 'home') {
    require_once('../controllers/registration_form.php');
} else

    require_once('../controllers/404.php');
