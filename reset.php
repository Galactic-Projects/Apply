<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
if(isset($_SESSION['userid'])){
    header("Location: account.php");
    exit;
}

require "app/data.php";
include "app/inc/header.php";
require "app/languages/lang_en.php";
include "app/inc/navbar.php";

if(isset($_GET['action'])) {

}