<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";

$id = $_SESSION['userid'];
$language = 'en';
if(isset($id)) {
    $email = getEmailById($id);
    $language = getLanguage($email);
}
require "app/languages/lang_" . $language . ".php";
include "app/inc/navbar.php";