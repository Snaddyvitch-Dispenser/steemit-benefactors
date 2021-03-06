<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$lifetime = 604800;
session_start();
setcookie(session_name(), session_id(), time() + $lifetime, "/");

function redirect()
{
    if (isset($_GET['state'])) {
        header("Location: " . $_GET['state']);
        die();
    } else {
        header("Location: https://cubiccastles.website/benefactor/");
        die();
    }
}

//vote%2Ccomment%2Ccomment_delete%2Ccomment_options%2Ccustom_json%2Cclaim_reward_balance%2Coffline
//https://v2.steemconnect.com/oauth2/authorize?client_id=cadawg.app&redirect_uri=https://cubiccastles.website/benefactor/callback.php&scope=vote%2Ccomment%2Ccomment_delete%2Ccomment_options%2Ccustom_json%2Cclaim_reward_balance%2Coffline

if (isset($_GET['access_token']) and isset($_GET['expires_in'])) {
    $_SESSION['code'] = $_GET['access_token'];
    if ((integer)$_GET['expires_in'] == 604800) {
        $_SESSION['expires'] = time() + 604800;
    } else {
        session_unset();
        session_regenerate_id(true);
        redirect();
    }
    $usr_name = require 'getLogin.php';
    if ($usr_name != false) {
        $_SESSION['user'] = $usr_name;
        $_SESSION["randstring"] = generateRandomString();
        redirect();
    } else {
        session_unset();
        session_regenerate_id(true);
        redirect();
    }
}
