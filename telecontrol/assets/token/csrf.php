<?php

if (password_verify($_SERVER["REMOTE_ADDR"], $_SESSION["hash_token_telecontrol"]) == false) {
    session_destroy();
    header('Location: ./home');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf = $_SESSION['csrf_token'];