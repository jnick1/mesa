<?php
require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
include_once GOOGLE_API_FILE;

define('HOST_URI', 'http://' . $_SERVER['HTTP_HOST'] . '/mesa/services/'); //Assumes mesa will be in a folder mesa, can be changed
session_start();


function redirect_local($url_end) {
    $redirect_uri = HOST_URI . $url_end;
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit();
}
