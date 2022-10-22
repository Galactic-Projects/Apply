<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
require "app/mysql.php";
require "app/data.php";
require "app/languages/lang_en.php";
include "app/inc/header.php";
include "app/inc/navbar.php";

if(!isset($_SESSION['USERID'])) {
    header("Location: /login.php");
    exit();
}