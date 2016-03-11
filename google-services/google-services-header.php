<?php
require_once __DIR__ . '/../vendor/autoload.php';
define('CLIENT_SECRET_PATH', __DIR__ . '/../client_secret.json');
define('HOST_URI', 'http://' . $_SERVER['HTTP_HOST'] . '/mesa/google-services/'); //Assumes mesa will be in a folder mesa, can be changed
session_start();
function redirect_local($url_end){
    $redirect_uri = HOST_URI . $url_end;
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit();
}
