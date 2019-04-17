<?php

$host = '';
$db_name = '';
$user = '';
$pass = '';
$sql_char = 'SET NAMES utf8';

try {

    $DBH = new PDO("mysql:host=$host;port=3306;dbname=$db_name", $user, $pass);
    $DBH->query($sql_char);

    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DBH->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (Exception $e) {

    echo $e->getMessage();
}