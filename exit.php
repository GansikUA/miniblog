<?php
include_once "ini/config.php";
include_once "ini/functions.php";
if (exit_auth()){
    header('Location: index.php');

}else {

    header("HTTP/1.0 404 Not Found");

}
