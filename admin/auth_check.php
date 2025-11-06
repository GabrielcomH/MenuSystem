<?php


session_start();


if (empty($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}


$tempoMaximoInativo = 1800; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $tempoMaximoInativo) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$_SESSION['last_activity'] = time(); 
